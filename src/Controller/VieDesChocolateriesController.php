<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VieDesChocolateriesController extends AbstractController
{
    #[Route('/chocolateries', name: 'app_chocolateries', methods:['GET'])]
    public function index(Request $request,ManagerRegistry $doctrine, UserRepository $userRepository, PostRepository $postRepository ): Response
    {

        $user = $this->getUser()->getUserIdentifier();
        $post = $postRepository->findAll($user);
        
        return $this->render('user/vie_des_chocolateries/index.html.twig', [
            'controller_name' => 'VieDesChocolateriesController',
            "post"=> $post,
        ]);

        
    }
}


