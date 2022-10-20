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
    
    public function profil(ManagerRegistry $doctrine, FileUploader $fileUploader, Request $request, $id, User $user, CatPostRepository $catPostRepository, CommentaireRepository $commentaireRepository ,PostRepository $post, ): Response
    {
        

        $userId = $this->getUser();

        // PUBLICATION D'UN COMMENTAIRE

            // On Vérifie si un commentaire à été envoyer

            if(isset($_POST['submit'])){

                // On récupère l'id du post

                $postId = $_POST['postId'];

                // On récupère l'objet du post grace à son ID

                $postSelected = $post->find($postId); // On peux également utiliser le Manager Registry : $postSelected = $doctrine()->getRepository(Post::Class)->find($postId);

                // On crée un nouvel objet de la classe Commentaire

                $commentaire = new Commentaire();

                // On rempli les données

                $commentaire->setCreatedAt(new \DateTimeImmutable());
                $commentaire->setUser($userId);
                $commentaire->setContenu($_POST['commentaire']);
                $commentaire->setPost($postSelected);

                // On envoi tout ça en BDD

                $commentaireRepository->add($commentaire, true);

                return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
            }     

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

                $image = $formPost->get('images')->getData();

                   if (!empty($image)) {
                       $imageFileName = $fileUploader->upload($image);
                       $newPost->setImagePost('../data/'. $imageFileName);
                   }

            $post->add($newPost, true);
            
              
            //Supression
            /*
            if ($this->isCsrfTokenValid('delete'.$posts->getId(), $request->request->get('_token'))) {
                $postRepository->remove($posts, true);
            }*/
               
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

            return $this->renderForm('user/profil_view/index.html.twig', [
                'formPost' => $formPost,
                "post"=> $postPerPage,
                "com" => $commentaireRepository->findByUser($user),
                "user"=> $user,
                "pages"=> $page,
                "currentPage"=>$currentPage,
            
            ]);

    
    }


}