<?php

namespace App\Controller\user;


use App\Entity\Actualite;
use App\Entity\Chocolaterie;
use App\Repository\ActualiteRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChocolateriesController extends AbstractController
{
    #[Route('utilisateur/chocolateries/{id}', name: 'app_chocolateries')]
    public function index(ChocolaterieRepository $chocoRepo, Chocolaterie $chocoEntity, ActualiteRepository $actRepo): Response
    {
        return $this->render('user/chocolateries/index.html.twig', [
            'controller_name' => 'ChocolateriesController',
            'chocolateries' => $chocoEntity,
            'chocoFindAll' => $chocoRepo->findAll(),
            'actus' => $actRepo->findActByChoc($chocoEntity),
            
        ]);
    }
}
