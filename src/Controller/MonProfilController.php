<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Form\UserType;
use App\Entity\CatPost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Service\FileUploader;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class MonProfilController extends AbstractController
{

    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET', 'POST']) ]
    

    public function profil(Post $posts,EntityManagerInterface $em, FileUploader $fileUploader, Request $request, $id, User $user, CatPostRepository $catPostRepository, CommentaireRepository $commentaireRepository ,PostRepository $post, Like $like, Commentaire $commentaire ): Response
{
    $userId = $this->getUser();
   
    // CREATION D'UN NOUVEAU POST

        // On crée un nouvel objet de la classe Post
    
        $newPost = new Post();

        // On apelle le formulaire des post

        $formPost = $this->createForm(PostType::class, $newPost);
        $formPost->handleRequest($request);

        //On remplie les champs non null

        $newPost->setUser($userId);
        $newPost->setCreatedAt(new \DateTimeImmutable());

        if ($formPost->isSubmitted() && $formPost->isValid()) {
    
        //Traite l'image 

                    /** @var UploadedFile $imageFile */

            $image = $formPost->get('images')->getData();

               if (!empty($image)) {
                   $imageFileName = $fileUploader->upload($image);
                   $newPost->setImagePost('../data/'. $imageFileName);
               }

        $em->persist($newPost);

        $em->flush();

        $post->add($newPost, true);

        return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
            
        }

    // PAGINATION

        // On stocke la page actuelle dans une variable


        $currentPage = (int)$request->query->get("pg", 1);


        // On détermine le nombre d'articles par page

        $perPage = 5;

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;
                
        // On récupère le nombre d'articles et on compte le nombre de pages et on arrondi à l'entier suppérieur

        $page = ceil(count($post->findByUser($user)) / $perPage);

        // On définis les articles à afficher en fonction de la page

        $postPerPage = $post->postPaginateUser($perPage, $firstObj, $user);

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
        
  
        'formPost' => $formPost,
        "post"=> $postPerPage,
        "com" => $commentaireRepository->findByUser($user),
        "user"=> $user,
        "pages"=> $page,

    ]);
}
 
}