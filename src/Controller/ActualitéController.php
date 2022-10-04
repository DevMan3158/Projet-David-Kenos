<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Service\Pagination;
use App\Repository\ActualiteRepository;
use App\Repository\ChocolaterieRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ActualitéController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(ChocolaterieRepository $chocRepo, ActualiteRepository $actRepo): Response
    {


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

        $page = ceil((count($actRepo->findAll())) / $perPage);

        // On définis les articles à afficher en fonction de la page

        $actPerPage = $actRepo->findAllAct($perPage, $firstObj);


        return $this->render('user/actualité/index.html.twig', [
            'controller_name' => 'ActualitéController',
            'findAllAct' => $actPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
            'allLieux' => $chocRepo->actLieux(),
        ]);
    }
}
