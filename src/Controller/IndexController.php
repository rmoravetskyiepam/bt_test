<?php

namespace App\Controller;

use App\Entity\SupportCase;
use App\Entity\User;
use App\Form\CreateCaseFormType;
use App\Repository\SupportCaseRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly LoggerInterface       $logger,
        private readonly SupportCaseRepository $supportCaseRepository
    )
    {
    }

    #[Route('/cases', name: 'support_cases', methods: Request::METHOD_GET)]
    public function indexAction(): Response
    {
        return $this->render('support/index.html.twig', [
            'supportCases' => $this->supportCaseRepository->findBy([],['id' => 'DESC']),
        ]);
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
            $newCase->setCreator($user);

            $uploadedFile = $form['imageFile']->getData();
            if(!empty($uploadedFile)) {
                $destination = $this->getParameter('kernel.project_dir') . '/public/images';
                $newFilename = $user->getId() . uniqid() . '.' . $uploadedFile->guessExtension();
                try {
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                } catch (FileException $e) {
                    $this->logger->error('ImageUpload: ' . $e->getMessage());
                    return new Response('Image Upload Failed.');
                }

                $newCase->setImageUrl('/images/' . $newFilename);
            }

            $this->supportCaseRepository->save($newCase, true);

            return $this->redirectToRoute('support_cases');
        }

        return $this->render('support/create.html.twig', ['createCaseForm' => $form->createView()]);
    }

    #[Route('/cases/{id}', name: 'get_support_case', methods: Request::METHOD_GET)]
    public function getCaseAction(SupportCase $supportCase): Response
    {
        return $this->render('support/case.html.twig', [
            'supportCase' => $supportCase,
        ]);
    }

}
