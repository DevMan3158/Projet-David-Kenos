<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestAccueilController extends AbstractController
{
    #[Route('/test/accueil', name: 'app_test_accueil')]
    public function index(): Response
    {
 
        $tableUser=[
            ['nom' => 'Kenos', 'prenom' =>'David' ,'poste' => 'Gérant des chocolateries','email' => 'David.Kenos@gmail.fr', 'roles' => ["ROLE_SUPER_ADMIN"] ],
            ['nom' => 'Alebat', 'prenom' =>'Evelyne ' ,'poste' => 'Chargée de clientèle ','email' => 'Evelyne.Alebat@gmail.fr', 'roles' => ["ROLE_USER"] ],
            ['nom' => 'Allemand', 'prenom' =>'Arthur' ,'poste' => 'Gérant','email' => 'Arthur.Allemand@gmail.fr', 'roles' => ["ROLE_ADMIN"] ],
            ['nom' => 'Mylenas', 'prenom' =>'Romain' ,'poste' => 'Chargé de clientèle','email' => 'Romain.Mylenas@gmail.fr', 'roles' => ["ROLE_USER"] ],
            ['nom' => 'Ousbema', 'prenom' =>'Sukaina' ,'poste' => 'Chocolatière','email' => 'Sukaina.Ousbema@gmail.fr', 'roles' => ["ROLE_USER"] ],
            ['nom' => 'Treik', 'prenom' =>'Eliott' ,'poste' => 'Chocolatier ','email' => 'Eliott.Treik@gmail.fr', 'roles' => ["ROLE_USER"] ],
            ['nom' => 'Raoul', 'prenom' =>'Marvin' ,'poste' => 'Chocolatier ','email' => 'Marvin.Raoul@gmail.fr', 'roles' => ["ROLE_USER"] ],
            ['nom' => 'Espinosa', 'prenom' =>'Leslie' ,'poste' => 'Chocolatière','email' => 'leslie.espinosa@gmail.com', 'roles' => ['ROLE_USER'] ],
            ['nom' => 'Chevallier', 'prenom' =>'Louis' ,'poste' => 'Chocolatier','email' => 'louis.chevalier@gmail.com', 'roles' => ['ROLE_USER'] ],
            ['nom' => 'Riviere', 'prenom' =>'Anthony' ,'poste' => 'Gérant','email' => 'anthony.riviere@gmail.com', 'roles' => ['ROLE_ADMIN']],
            
            
            ];

        return $this->render('test_accueil/index.html.twig', [
            'controller_name' => 'TestAccueilController',
            'tableUser' => $tableUser,
        ]);
    }
}
