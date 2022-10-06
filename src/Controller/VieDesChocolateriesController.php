<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use DateTimeImmutable;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\CatPostRepository;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VieDesChocolateriesController extends AbstractController
{
    #[Route('/chocolateries', name: 'app_chocolateries', methods:['GET'])]
    public function index(/*Post $post,*/ Request $request, PostRepository $postRepository, UserRepository $userRepository, CatPostRepository $catPost): Response
    {

        // PAGINATION

        if(!empty($_GET['pg'])){
            $currentPage = (int) strip_tags($_GET['pg']);
        } else {
            $currentPage = 1;
        }

        // On détermine le nombre d'articles par page

        $perPage = 5;

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;
                
        // On récupère le nombre d'articles et on compte le nombre de pages et on arrondi à l'entier suppérieur

        $page = ceil((count($postRepository->findAll())) / $perPage);

        // On définis les articles à afficher en fonction de la page

        $postPerPage = $postRepository->postPaginate($perPage, $firstObj);



        /*// FORMULAIRE POUR COMMENTAIRES

        //On appel l'entité commentaire
        $commentaire = new Commentaire();

        //On appel le formulaire 
        $form = $this->createForm(CommentaireType::class, $commentaire);
        
        $form->handleRequest($request);
        $userId = $this->getUser();

        //On remplie les champs non null 
        $commentaire->setCreatedAt(new DateTimeImmutable());
        $commentaire->setUser($userId);
        $commentaire->setPost($post);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaireRepository->add($commentaire, true);

        }*/

        
        
        return $this->render('user/vie_des_chocolateries/index.html.twig', [
            'controller_name' => 'VieDesChocolateriesController',
            'users' => $userRepository->findAllOrderedUser(),
            "post"=> $postPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
            'catPost' => $catPost ->findAll(),
            //'form' => $form,
        ]);
    }
}


