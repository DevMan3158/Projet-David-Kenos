<?php

namespace App\Controller;

use App\Service\Pagination;
use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ActualitéController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(ChocolaterieRepository $chocRepo, $page, $currentPage, Pagination $paginationService): Response
    {


                // On détermine le nombre d'articles par page
        
                $perPage = 4;

                // On détermine le nombre d'users total

                $nbAct = $actRepo->countAct();

                // On récupère les éléments

                $elements = $this->getDoctrine()->getRepository(Actualite::class)->findAll();

                // On récupère le service pagination

                $arrayPagination = $paginationService->pagination($elements, $perPage);

                // On définis les articles à afficher en fonction de la page

                $actPerPage = $this->getDoctrine()->getRepository(Actualite::class)->findBy([], ['id' => 'DESC'], $perPage, $firstObj);


        return $this->render('user/actualité/index.html.twig', [
            'controller_name' => 'ActualitéController',
            'findAllAct' => $actPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
            'allLieux' => $chocRepo->actLieux(),
        ]);
    }
}
