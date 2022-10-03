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
    public function index(ChocolaterieRepository $chocRepo, ActualiteRepository $actRepo, Pagination $paginationService): Response
    {


                // On détermine le nombre d'articles par page
        
                $perPage = 4;

                // On récupère les éléments

                $elements = $this->$actRepo->findAll();

                // On récupère le service pagination

                $arrayPagination = $paginationService->pagination($elements, $perPage);

                $page = ceil((count($elements)) / $perPage);

                // On définis les articles à afficher en fonction de la page

                $actPerPage = $this->$actRepo->findAllAct($perPage, $firstObj);


        return $this->render('user/actualité/index.html.twig', [
            'controller_name' => 'ActualitéController',
            'findAllAct' => $actPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
            'allLieux' => $chocRepo->actLieux(),
        ]);
    }
}
