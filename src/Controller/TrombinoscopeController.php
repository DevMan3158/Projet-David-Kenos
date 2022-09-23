<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrombinoscopeController extends AbstractController
{
    #[Route('/trombinoscope', name: 'app_trombinoscope')]
    public function index(): Response
    {
        return $this->render('user/trombinoscope/index.html.twig', [
            'controller_name' => 'TrombinoscopeController',
        ]);
    }
}
