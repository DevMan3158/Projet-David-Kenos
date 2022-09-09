<?php

namespace App\DataFixtures;


use App\Entity\Commentaire;
use DatetimeImmutable;
use App\DataFixtures\PostFixtures;
use App\DataFixtures\UserFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;




class CommentaireFixtures extends Fixture implements DependentFixtureInterface
{
    //Ajout d'une fonction pour le haché le mot de passe 
    //public const CHOCOLATERIE_REFERENCE = 'user-robin';



    /*public const USER_REFERENCE = 'user-gary';*/
    public function load(ObjectManager $manager): void
    {

     

        for ($i=0; $i < 5 ; $i++) { 
        
        $commentaire = new Commentaire();
        $commentaire->setCreatedAt(new DatetimeImmutable());
        $commentaire->setContenu('Ceci est le contenu du commentaire');
        $commentaire->setPost($this->getReference('post_'.$i));
        $commentaire->setUser($this->getReference('user_'.$i));


        $manager->persist($commentaire);
        }


        $manager->flush();
    }
    
        
        //$this->addReference(self::USER_REFERENCE, $user);

        public function getDependencies()
        {
            return array(
                PostFixtures::class,
                UserFixtures::class,
            );
        }
}