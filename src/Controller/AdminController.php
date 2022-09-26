<?php

namespace App\Controller;

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
        ]);
    }
}
