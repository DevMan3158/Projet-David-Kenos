<?php

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ActualitéController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(ActualiteRepository $actRepo, ChocolaterieRepository $chocRepo): Response
    {
        return $this->render('user/actualité/index.html.twig', [
            'controller_name' => 'ActualitéController',
            'findAllAct' => $actRepo->findAll(),
            'allLieux' => $chocRepo->actLieux(),
        ]);
    }
}
