<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\SupportCase;
use App\Service\ImageService;
use App\Entity\Enum\StatusType;
use App\Form\CreateCaseFormType;
use App\Repository\SupportCaseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly ImageService          $imageService,
        private readonly SupportCaseRepository $supportCaseRepository
    )
    {
    }

    #[Route('/cases', name: 'support_cases', methods: Request::METHOD_GET)]
    public function indexAction(): Response
    {
        /**@var User $user **/
        $user = $this->getUser();
        $searchCriteria = !in_array(User::SUPPORT_SPECIALIST_ROLE, $user->getRoles()) ? ['creator' => $user] : [];

        return $this->render(
            'support/index.html.twig',
            ['supportCases' => $this->supportCaseRepository->findBy($searchCriteria, ['id' => 'DESC'])]
        );
    }

    #[Route('/manager/analytic', name: 'analytic', methods: Request::METHOD_GET)]
    public function statisticAction(): Response
    {
        /**@var User $user **/
        $user = $this->getUser();
        $searchCriteria = !in_array(User::SUPPORT_SPECIALIST_ROLE, $user->getRoles()) ? ['creator' => $user] : [];

        return $this->render(
            'support/index.html.twig',
            ['supportCases' => $this->supportCaseRepository->findBy($searchCriteria, ['id' => 'DESC'])]
        );
    }

    #[Route('/cases/create', name: 'create_support_case', methods: [Request::METHOD_POST, Request::METHOD_GET])]
    public function createCaseAction(Request $request): Response
    {
        $form = $this->createForm(CreateCaseFormType::class, new SupportCase());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**@var User $user **/
            $user = $this->getUser();
            /**@var SupportCase $newCase **/
            $newCase = $form->getData();

            $uploadedFile = $form['imageFile']->getData();
            if(!empty($uploadedFile)) {
                $imagePath = $this->imageService->uploadImage($uploadedFile, $user->getId());
                if(empty($imagePath)) {
                    return new Response('Image Upload Failed.');
                }

                $newCase->setImageUrl($imagePath);
            }

            $newCase->setCreator($user);
            $this->supportCaseRepository->save($newCase, true);

            return $this->redirectToRoute('support_cases');
        }

        return $this->render('support/create.html.twig', ['createCaseForm' => $form->createView()]);
    }

    #[Route('/cases/{id}', name: 'get_support_case', methods: Request::METHOD_GET)]
    public function getCaseAction(SupportCase $supportCase): Response
    {
        /**@var User $user **/
        $user = $this->getUser();

        if(in_array(User::SUPPORT_SPECIALIST_ROLE, $user->getRoles())) {
            $statuses = StatusType::arrayFormat();
        }

        return $this->render('support/case.html.twig', [
            'supportCase' => $supportCase,
            'statuses' => $statuses ?? null
        ]);
    }

    #[Route('/change-status/{id}/{status}', name: 'change_support_case_status', methods: [Request::METHOD_GET])]
    public function changeCaseStatusAction(SupportCase $supportCase, string $status): Response
    {
        try {
            $supportCase->setStatus($status);
            $this->supportCaseRepository->save($supportCase, true);
        } catch (\Throwable $e) {
            return new Response($e->getMessage(), Response::HTTP_FORBIDDEN);
        }

        return $this->render('support/case.html.twig', [
            'supportCase' => $supportCase,
            'statuses' => StatusType::arrayFormat()
        ]);
    }

}
