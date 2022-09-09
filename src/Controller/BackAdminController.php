<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackAdminController extends AbstractController
{
    #[Route('admin/back/admin', name: 'app_back_admin')]
    public function index(): Response
    {
        return $this->render('back_admin/index.html.twig', [
            'controller_name' => 'BackAdminController',
        ]);
    }
}
