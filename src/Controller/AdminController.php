<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('admin/acc', name: 'app_back_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('admin/crud', name: 'app_back_crud')]
    public function crud(): Response
    {
        return $this->render('admin/crud.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
