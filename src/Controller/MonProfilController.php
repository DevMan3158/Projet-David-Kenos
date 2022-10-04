<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\Commentaire;
use App\Repository\PostRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonProfilController extends AbstractController
{

    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET']) ]
    
    public function profil($id, User $user, PostRepository $post, Like $like, Commentaire $commentaire ): Response
{

return $this->render('user/profil_view/index.html.twig', [
    
    'nbCom' => $commentaire,
    'nbLike' => $like,
    "post"=> $post->findByUser($user),
    "user"=> $user ,

    ]);
}
}