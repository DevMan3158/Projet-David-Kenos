<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\ActualiteRepository;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(PostRepository $postRepo, ActualiteRepository $actRepo): Response
    {
        return $this->render('user/accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'findAllPost' => $postRepo->findAll(),
            'findAllAct' => $actRepo->findAll(),
        ]);
    }
}
