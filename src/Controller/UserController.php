<?php

namespace App\Controller;


use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('utilisateur/profil', name: 'app_user', methods:['GET']) ]
    
            public function index(Request $request,ManagerRegistry $doctrine, UserRepository $userRepository, PostRepository $postRepository ): Response
    {
        $user = $this->getUser()->getId();
        $post = $postRepository->findBy(array('id' => $user));
        
        return $this->render('user/profil_view/index.html.twig', [

            "post"=> $post,
            
        ]);
    }
}
