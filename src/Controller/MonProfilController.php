<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\PersistentCollection;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonProfilController extends AbstractController
{
    #[Route('utilisateur/profil/{id}', name: 'app_mon_profil', methods:['GET']) ]
    
            public function index(Request $request, $id,ManagerRegistry $doctrine, UserRepository $userRepository, PostRepository $postRepository, LikeRepository $likeRepository, CommentaireRepository $commentaireRepository ): Response
    {
        $user = $this->getUser();
        $post = $postRepository->findAll($user);
        
        return $this->render('user/profil_view/index.html.twig', [
            'nbCom' => $commentaireRepository ->findAllWithCom(),
            'nbLike' => $likeRepository ->findAllWithLike(),
            "post"=> $post,
            "user"=> $user,

        ]);
    }
}