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
  




    public function load(ObjectManager $manager): void
    {

     

        for ($i=0; $i < 5 ; $i++) { 
        
        $Post = new Post();
        $Post->setContenu("Lorem ipsum dolor sit amet consectetur adipisicing elit.Aspernatur nostrum aut, voluptates laudantium minima voluptas dolor pariatur unde veritatis, similique eius. Laboriosam molestiae consequuntur facere. Dolorum maiores odio repellendus voluptate!");
        $Post->setCreatedAt(new DatetimeImmutable());
        $Post->setImagePost("https://via.placeholder.com/150");
        $Post->setImagePostAlt("https://via.placeholder.com/150");
        $Post->setCatPost($this->getReference('categorie_'.$i));
        $Post->setUser($this->getReference('user_'.$i));
        $this->addReference('post_'.$i, $Post);


        $manager->persist($Post);
        }


        $manager->flush();
    }
    
        
       

        public function getDependencies()
        {
            return array(
                CatPostFixtures::class,
                UserFixtures::class,
            );
        }
}