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
    
    public function profil(EntityManagerInterface $manager, Post $post, Request $request,int $id, User $user, CatPostRepository $catPostRepository, CommentaireRepository $commentaireRepository ,PostRepository $postrepository, Like $like, Commentaire $commentaire ): Response
{
    //récupére id de l'user 
    $userId = $this->getUser();

    $currentPost = $postrepository->findByUser($user);
    //dd($currentPost);

    //$currentPost = $postrepository->findByPost($id);
    //dd($currentPost);
   
    //TEST BOUCLE
    //$forms = [];
    //dd($forms);

    /*foreach ($currentPost as $index => $commentaire) {
        $commentaire = new Commentaire();

        
        $form = $this->createForm($index, CommentaireType::class, $commentaire->createView());


        $form->handleRequest($request);


        $commentaire->setUser($userId);
        $commentaire->setCreatedAt(new \DateTimeImmutable());
        $commentaire->setPost($currentPost);

        

        if ($form->isSubmitted() && $form->isValid()) {
            //Formulaire envoyé et données valides
            //$commentaireRepository->add($commentaire, true);

            return $this->redirectToRoute('app_profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        $forms[$index] = $form->createView();

        $manager->persist($form);
       
       
        $manager->flush();
}*/


//On instencie l'entité commentaire

     $commentaire = new Commentaire();
     //dd($commentaire);

     //Création de l'objet formulaire (deux paramètres)
     $form = $this->createForm(CommentaireType::class, $commentaire);
      //dd($form );
     // dd($commentaire);


    
     //On remplie les champs non null 
    //$currentPost = $form->get('post')->getData();
    //dd($currentPost );


    //Transmet id user  
     $commentaire->setUser($userId);
    //dd($commentaire);


    //Transmet la date  
    $commentaire->setCreatedAt(new \DateTimeImmutable());
                           
     //Transmet l'id du post 
    // $commentaire->setPost($this -> $currentPost);
     //dd($commentaire);

    // Récupère les données saisies
     $form->handleRequest($request);
     //dd($request );

    //Vérifie si le fomulaire à était envoyé et si les donnés sont valides
    if ($form->isSubmitted() && $form->isValid()) {
        //Formulaire envoyé et données valides
        $commentaireRepository->add($commentaire, true);

        //Redirige vers la même page avec l'user 
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