<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

class TrombinoscopeController extends AbstractController
{
    #[Route('/trombinoscope', name: 'app_trombinoscope')]
    public function index(UserRepository $userRepository): Response
    {

        return $this->render('user/trombinoscope/index.html.twig', [
            'controller_name' => 'TrombinoscopeController',
            'nbUser' => $userRepository->countUser(),
            'findAll' => $userRepository->findAll(),
        ]);
    }
}
