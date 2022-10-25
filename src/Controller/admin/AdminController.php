<?php

namespace App\Controller\admin;

use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\CatPostRepository;
use App\Repository\ActualiteRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    #[Route('superadmin/', name: 'app_super_admin')]
    #[Route('admin/', name: 'app_admin')]
    public function index(ChocolaterieRepository $chocoRepo, UserRepository $userRepo, ActualiteRepository $actRepo,
     CatPostRepository $catPostRepo, PostRepository $postRepo): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'countChoco' => $chocoRepo->countChoco(),
            'countUser' => $userRepo->countUser(),
            'countPost' => $postRepo->countPost(),
            'countAct' => $actRepo->countAct(),
            'countCat' => $catPostRepo->countCat(),
            'accAct' => $actRepo->accAct(),
            /* 
                Pour les count, 3 possibilitées : 
                    - Faire une requete count dans les repo comme si dessus.
                    - Ecrire simplement : $chocoRepo->findAll()->count() peux etre meme $chocoEntity->count() ( à tester )
                    - Envoyer simplement l'intégralité de l'entité à la view dans une variable, puis sur twig écrire "votreVariable"|lenght
            */
        ]);
    }
}
