<?php

namespace App\DataFixtures;


use App\Entity\Post;
use DatetimeImmutable;
use App\DataFixtures\CatPostFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;




class PostFixtures extends Fixture implements DependentFixtureInterface
{
    //Ajout d'une fonction pour le haché le mot de passe 
    //public const CHOCOLATERIE_REFERENCE = 'user-robin';



    /*public const USER_REFERENCE = 'user-gary';*/
    public function load(ObjectManager $manager): void
    {

     

        for ($i=0; $i < 5 ; $i++) { 
        
        $Post = new Post();
        $Post->setContenu("Ceci est le contenu du post");
        $Post->setCreatedAt(new DatetimeImmutable());
        $Post->setImagePost("https://via.placeholder.com/150");
        $Post->setImagePostAlt("https://via.placeholder.com/150");
        $Post->setCatPost($this->getReference('categorie_'.$i));
        $this->addReference('post_'.$i, $Post);


        $manager->persist($Post);
        }


        $manager->flush();
    }
    
        
        //$this->addReference(self::USER_REFERENCE, $user);

        public function getDependencies()
        {
            return array(
                CatPostFixtures::class,
            );
        }
}