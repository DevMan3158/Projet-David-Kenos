<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('utilisateur/profil', name: 'app_user', methods:['GET']) ]
    public function index(Request $request, UserRepository $userRepository, PostRepository $postRepository  ): Response
    {
        return $this->render('user/profil_view/index.html.twig', [

            'postRepository' => $postRepository->findAll(),
            'userRepository' => $userRepository->findAll(),
        ]);
    }
}
