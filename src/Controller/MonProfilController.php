<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\CatPost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\PostRepository;
use App\Repository\CatPostRepository;
use Doctrine\ORM\PersistentCollection;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonProfilController extends AbstractController
{


    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET', 'POST']) ]
    
    public function profil(Request $request, $id, User $user, CatPostRepository $catPostRepository, CommentaireRepository $commentaireRepository ,PostRepository $post, Like $like, Commentaire $commentaire ): Response
{
    //$commentaire = $commentaireRepository->findAll($post);

    $commentaire = new Commentaire();
    $form = $this->createForm(CommentaireType::class, $commentaire);
    $form->handleRequest($request);
    $commentaire->setCreatedAt(new \DateTimeImmutable());


    if ($form->isSubmitted() && $form->isValid()) {
        $commentaireRepository->add($commentaire, true);
        return $this->redirectToRoute('app_profil', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('user/profil_view/index.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form,
        "post"=> $post->findByUser($user),
        "com" => $commentaireRepository->findByUser($user),
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