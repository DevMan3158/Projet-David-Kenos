<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PostRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonProfilController extends AbstractController
{


    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET']) ]
    
    public function profil(User $user, PostRepository $post)
{

    return $this->render('user/profil_view/index.html.twig', [
    
    "post"=> $post->findByUser($user),
    "user"=> $user,

   /* #[Route('utilisateur/profil/{id}', name: 'app_mon_profil', methods:['GET']) ]
    
            public function index(Request $request, $id,ManagerRegistry $doctrine, UserRepository $userRepository, PostRepository $postRepository, LikeRepository $likeRepository, CommentaireRepository $commentaireRepository ): Response
    {
        $user = $this->getUser();
        $post = $postRepository->findAll($user);
        
        return $this->render('user/profil_view/index.html.twig', [
            'nbCom' => $commentaireRepository ->findAllWithCom(),
            'nbLike' => $likeRepository ->findAllWithLike(),
            "post"=> $post,
            "user"=> $user,*/


    ]);
}
}