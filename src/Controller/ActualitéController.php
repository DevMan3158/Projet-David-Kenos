<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActualitéController extends AbstractController
{
    #[Route('/actualit/', name: 'app_actualit_')]
    public function index(): Response
    {
        return $this->render('user/actualité/index.html.twig', [
            'controller_name' => 'ActualitéController',
        ]);
    }
}
