<?php

namespace App\DataFixtures;


use App\Entity\CatPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;




class CatPostFixtures extends Fixture 
{
    //Ajout d'une fonction pour le haché le mot de passe 
    //public const CHOCOLATERIE_REFERENCE = 'user-robin';



    /*public const USER_REFERENCE = 'user-gary';*/
    public function load(ObjectManager $manager): void
    {

      $TableCatPost =[
            ['nom' => 'Animations'],
            ['nom' => 'Divers'],
            ['nom' => 'Vie de l\'\entreprise'],
            ['nom' => 'Améliorations'],
            ['nom' => 'Questions'],

        ];

        for ($i=0; $i < 5 ; $i++) { 
        
        $catPost = new CatPost();
        $catPost->setNom($TableCatPost[$i]['nom']);
        $this->addReference('categorie_'.$i, $catPost);
        $manager->persist($catPost);

        }


        $manager->flush();
    }
    
        
        //$this->addReference(self::USER_REFERENCE, $user);


}