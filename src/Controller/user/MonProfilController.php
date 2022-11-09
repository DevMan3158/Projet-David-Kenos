<?php

namespace App\Controller\user;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\user\PostType;
use App\Entity\Commentaire;
use App\Form\user\CommentaireType;
use App\Service\FileUploader;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MonProfilController extends AbstractController
{

    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET', 'POST']) ]
    public function profil(FileUploader $fileUploader, Request $request, UserRepository $userRepo, CommentaireRepository $commentaireRepository ,PostRepository $post, int $id ): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Résolution bug ParamConverter, on redirige l'utilisateur s'il va sur la page d'un untilisateur innéxistant.

        $userId = $this->getUser();

        $user = $userRepo->find($id);

        if( $user == null ){
            
            return $this->redirectToRoute('app_profil',['id' => $userId->getId()], Response::HTTP_SEE_OTHER);

        }


        // PUBLICATION D'UN COMMENTAIRE

            // On Vérifie si un commentaire à été envoyer

            if(isset($_POST['submit'])){

                // On récupère l'id du post

                $postId = $_POST['postId'];

                // On récupère l'objet du post grace à son ID

                $postSelected = $post->find($postId); // On peux également utiliser le Manager Registry : $postSelected = $doctrine()->getRepository(Post::Class)->find($postId);

                // On crée un nouvel objet de la classe Commentaire

                $newCommentaire = new Commentaire();

                // On rempli les données

                $newCommentaire->setCreatedAt(new \DateTimeImmutable());
                $newCommentaire->setUser($userId);
                $newCommentaire->setContenu($_POST['commentaire']);
                $newCommentaire->setPost($postSelected);

                // On envoi tout ça en BDD

                $commentaireRepository->add($newCommentaire, true);

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

            return $this->redirectToRoute('app_profil', ['id' => $user->getId()]);
            
              
            ////Supression
            //
            //if ($this->isCsrfTokenValid('delete'.$posts->getId(), $request->request->get('_token'))) {
            //    $postRepository->remove($posts, true);
            //}
               
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

    // LIKES <3

        #[Route('/post/{id}/likes', name: 'app_post_likes', methods: ['GET'])]
    
        public function like(Post $post, LikeRepository $likeRepo): Response
    
        {
            $user = $this->getUser();
        
            // On empèche l'utilisateur de liker s'il n'est pas authentifié
        
            if(!$user) return $this->json([
                'code' => 403,
                'message' => "Vous n'êtes pas autorisé à visiter cette page",
            ], 403);
        
            // Si l'utilisateur à déja liker le post, on retire le like
        
            if($post->isLikedByUser($user)) {
                $newLike = $likeRepo->findOneBy([
                    'post' => $post,
                    'user' => $user,
                ]);
            
                $likeRepo->remove($newLike, true);
            
                return $this->json([
                    'code' => 200,
                    'message' => 'Like bien supprimé',
                    'likes' => $likeRepo->count(['post' => $post])
                ], 200);
            }
        
            // Sinon on rajoute le like :) 
        
            $newLike = new Like();
            $newLike->setPost($post)
                 ->setUser($user);
        
                $likeRepo->add($newLike, true);
        
            return $this->json([
            'code' => 200,
            'message' => 'Like bien ajouté',
            'likes' => $likeRepo->count(['post' => $post])
            ], 200);
        }

}