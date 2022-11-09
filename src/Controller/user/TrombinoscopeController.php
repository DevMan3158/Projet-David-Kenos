<?php

namespace App\Controller\user;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrombinoscopeController extends AbstractController
{
    #[Route('/trombinoscope', name: 'app_trombinoscope')]
    public function index(UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if(!empty($_GET['pg'])){
            $currentPage = (int) strip_tags($_GET['pg']);
        } else {
            $currentPage = 1;
        }

        // On détermine le nombre d'articles par page

        $perPage = 15;

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;
                
        // On récupère le nombre d'articles et on compte le nombre de pages et on arrondi à l'entier suppérieur

        $page = ceil((count($userRepository->findAll())) / $perPage);

        // On définis les articles à afficher en fonction de la page

        $userPerPage = $userRepository->findAllWithChoco($perPage, $firstObj);

        return $this->render('user/trombinoscope/index.html.twig', [
            'controller_name' => 'TrombinoscopeController',
            'nbUser' => $userRepository->countUser(),
            'findAll' => $userPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
        ]);
    }
}
