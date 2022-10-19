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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VieDesChocolateriesController extends AbstractController
{
    #[Route('/viedeschocolateries', name: 'app_viedeschocolateries', methods:['GET'])]
    public function index(/*Post $post,*/ Request $request, PostRepository $postRepository, UserRepository $userRepository, CatPostRepository $catPost): Response
    {

        // PAGINATION

        // On stocke la page actuelle dans une variable

        $currentPage = (int)$request->query->get("pg", 1);

        // On récupère les filtres
        $filters = $request->get("categories");

        // On détermine le nombre d'articles par page

        $perPage = 4;

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;
                
        // On récupère le nombre d'articles et on compte le nombre de pages et on arrondi à l'entier suppérieur

        $page = ceil(($postRepository->countPost($filters)) / $perPage);

        // On définis les articles à afficher en fonction de la page

        $postPerPage = $postRepository->postPaginateFilters($perPage, $firstObj, $filters);
  

        // On vérifie si l'ont a une requete AJAX

        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('user/templates/posts.html.twig', [
                    'controller_name' => 'VieDesChocolateriesController',
                    "post"=> $postPerPage,
                    'pages' => $page,
                    'currentPage' => $currentPage,
                ])
            ]);
        }    
        
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


