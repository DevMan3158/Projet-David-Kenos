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
  

    public function load(ObjectManager $manager): void
    {

     

        for ($i=0; $i < 5 ; $i++) { 
        
        $commentaire = new Commentaire();
        $commentaire->setCreatedAt(new DatetimeImmutable());
        $commentaire->setContenu('Lorem ipsum dolor sit amet consectetur adipisicing elit.Aspernatur nostrum aut, voluptates laudantium minima voluptas dolor pariatur unde veritatis, similique eius. Laboriosam molestiae consequuntur facere.');
        $commentaire->setPost($this->getReference('post_'.$i));
        $commentaire->setUser($this->getReference('user_'.$i));


        $manager->persist($commentaire);
        }


        $manager->flush();
    }
    
    

        public function getDependencies()
        {
            return array(
                PostFixtures::class,
                UserFixtures::class,
            );
        }
}