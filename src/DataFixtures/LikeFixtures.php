<?php

namespace App\DataFixtures;


use App\Entity\Like;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\PostFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;




class LikeFixtures extends Fixture implements DependentFixtureInterface
{
 


    public function load(ObjectManager $manager): void
    {

  

        for ($i=0; $i < 5 ; $i++) { 
            
        $like = new Like();

        $like->setPost($this->getReference('post_'.$i));

        $like->setUser($this->getReference('user_'.$i));

     
 
        
        $manager->persist($like);
    }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            PostFixtures::class,
        );
    }
}