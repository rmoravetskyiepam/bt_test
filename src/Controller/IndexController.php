<?php

namespace App\Controller;

use App\Entity\SupportCase;
use App\Repository\SupportCaseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly SupportCaseRepository $supportCaseRepository
    )
    {
    }

    #[Route('/', name: 'app_support', methods: Request::METHOD_GET)]
    public function indexAction(): Response
    {
        return $this->render('support/index.html.twig', [
            'supportCases' => $this->supportCaseRepository->findBy([],['id' => 'DESC']),
        ]);
    }

    #[Route('/cases/{id}', name: 'get_support_case', methods: Request::METHOD_GET)]
    public function getCaseAction(SupportCase $supportCase): Response
    {
        return $this->render('support/case.html.twig', [
            'supportCase' => $supportCase,
        ]);
    }

}
