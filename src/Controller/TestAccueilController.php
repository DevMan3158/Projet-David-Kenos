<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestAccueilController extends AbstractController
{
    #[Route('/test/accueil', name: 'app_test_accueil')]
    public function index(): Response
    {
        return $this->render('test_accueil/index.html.twig', [
            'controller_name' => 'TestAccueilController',
        ]);
    }
}
