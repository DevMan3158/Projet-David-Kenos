<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VieDesChocolateriesController extends AbstractController
{
    #[Route('/vie/des/chocolateries', name: 'app_vie_des_chocolateries')]
    public function index(): Response
    {
        return $this->render('user/vie_des_chocolateries/index.html.twig', [
            'controller_name' => 'VieDesChocolateriesController',
        ]);
    }
}
