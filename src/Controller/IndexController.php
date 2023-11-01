<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_support', methods: Request::METHOD_GET)]
    public function index(): Response
    {
        return $this->render('support/index.html.twig', [
            'controller_name' => 'SupportController',
        ]);
    }

}
