<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('admin/back', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('back_admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
