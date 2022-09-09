<?php

namespace App\DataFixtures;


use App\Entity\CatPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;




class CatPostFixtures extends Fixture 
{
 




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
    
        



}