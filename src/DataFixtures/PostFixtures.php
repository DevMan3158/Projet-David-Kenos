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

        $tableImg=[
            ['ImagePost'=>'../img/posts/paysage.jpeg'],
            ['ImagePost'=>'../img/posts/restaurant-1.jpeg'],
            ['ImagePost'=>'../img/posts/reunion.jpeg'],
            ['ImagePost'=>'../img/posts/team-soleil.jpeg'],
            ['ImagePost'=>'../img/posts/visio.jpeg'],
            ];

     

        for ($i=0; $i < 5 ; $i++) { 
        
        $post = new Post();
        $post->setContenu("Lorem ipsum dolor sit amet consectetur adipisicing elit.Aspernatur nostrum aut, voluptates laudantium minima voluptas dolor pariatur unde veritatis, similique eius. Laboriosam molestiae consequuntur facere. Dolorum maiores odio repellendus voluptate!");
        $post->setCreatedAt(new DatetimeImmutable());
        $post->setImagePost($tableImg[$i]['ImagePost']);
        $post->setImagePostAlt("https://via.placeholder.com/150");
        $post->setCatPost($this->getReference('categorie_'.$i));
        $post->setUser($this->getReference('user_'.$i));
        $this->addReference('post_'.$i, $post);


        $manager->persist($post);
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