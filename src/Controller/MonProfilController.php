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
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class MonProfilController extends AbstractController
{

    

    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET', 'POST']) ]
    
    public function profil(EntityManagerInterface $em, Post $post, Request $request,int $id, User $user, CatPostRepository $catPostRepository, CommentaireRepository $commentaireRepository ,PostRepository $postrepository, Like $like, Commentaire $commentaire ): Response
{
    //récupére id de l'user 
    $userId = $this->getUser();

    //$currentPost = $postrepository->findByUser($user);
    //dd($currentPost);
    $post = $em->getRepository('App\Entity\Post')->find($post);

    $currentPost = $postrepository->findByPost($id);

    $currentCom = $commentaireRepository->findbyCom($post);

    //dd($currentPost);
   
    //TEST BOUCLE
    
//   $form = [];
//
//   //dd($currentCom);
//
//   foreach ($currentPost as $index ) {
//       $commentaire = new Commentaire();
//       
//       //$key = $key ;
//       $form[$index->getId()] = $this->createForm(CommentaireType::class, $commentaire);
//       
//       $commentaire->setUser($userId);
//       //dd($commentaire);
//   
//       //Transmet la date  
//       $commentaire->setCreatedAt(new \DateTimeImmutable());
//
//      // $commentaire->setPost(['id']);
//
//       $form[$index->getId()]->handleRequest($request);
//
//      // if ($forms->isSubmitted() && $forms-s>isValid()) {
//      //     //        //Formulaire envoyé et données valides
//      //     //        $commentaireRepository->add($commentaire, true);
//      //     //
//      //     //        //Redirige vers la même page avec l'user 
//      //     //        return $this->redirectToRoute('app_profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
//      //         }
//                       
//      
//       $form[$index->getId()] = $form[$index->getId()]->createView();
//
//   }
//   

   


   $commentaire = new Commentaire();
   $form = $this->createForm(CommentaireType::class, $commentaire);

   //$currentPost = $form->get('post')->getData();

   $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()){

       $commentaire->setUser($userId);
       $commentaire->setCreatedAt(new \DateTimeImmutable());
       $commentaire->setPost($post);

      $commentaireRepository->add($commentaire, true);
      return $this->redirectToRoute('app_profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
  }
    //on envoie à la vue 
    return $this->renderForm('user/profil_view/index.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form,
        "post"=> $postrepository->findByUser($user),
        "com" => $commentaireRepository->findByUser($user),
        "user"=> $user,
        "currentPost" => $currentPost,
        
        
    ]);
}
 
}