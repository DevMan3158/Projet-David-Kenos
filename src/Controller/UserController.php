<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('utilisateur/mon-espace', name: 'app_user', methods:['GET']) ]
    public function index(Request $request, UserRepository $userRepository  ): Response
    {
        return $this->render('user/index.html.twig', [

          
            'userRepository' => $userRepository->findAll(),
        ]);
    }
}
