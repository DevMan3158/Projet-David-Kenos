<?php

namespace App\Controller;

use App\Repository\ActualiteRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ActualitéController extends AbstractController
{
    #[Route('/actualite', name: 'app_actualite')]
    public function index(ActualiteRepository $actRepo, ChocolaterieRepository $chocRepo): Response
    {

                // On détermine sur quelle page on se trouve

                if(!empty($_GET['pg'])){
                    $currentPage = (int) strip_tags($_GET['pg']);
                } else {
                    $currentPage = 1;
                }
        
                // On détermine le nombre d'users total
        
                $nbAct = $actRepo->countAct();
        
                // On détermine le nombre d'articles par page
        
                $perPage = 4;
        
                // On calcule le nombre de page total
        
                $page = ceil($nbAct / $perPage);
        
                // Calcul du premier article de la page
        
                $firstObj = ($currentPage * $perPage) - $perPage;

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
