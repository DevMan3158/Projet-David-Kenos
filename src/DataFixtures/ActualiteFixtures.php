<?php

namespace App\DataFixtures;


use App\Entity\Actualite;
use App\DataFixtures\ChocolaterieFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ActualiteFixtures extends Fixture implements DependentFixtureInterface
{
    public const CHOCOLATERIE_REFERENCE = 'user-robin';
    public function load(ObjectManager $manager): void
    {

        for ($i=0; $i < 5 ; $i++) { 
        

            $actualite = new Actualite();
            $actualite->setContenu("Lorem ipsum dolor sit amet consectetur adipisicing elit.Aspernatur nostrum aut, voluptates laudantium minima voluptas dolor pariatur unde veritatis, similique eius. Laboriosam molestiae consequuntur facere. Dolorum maiores odio repellendus voluptate!");
            $actualite->setCratedAt(new \DateTimeImmutable());
            $actualite->setImageActu('../img/act/chocolat_act'.$i.'.jpg');
            $actualite->setImageActuAlt('https://via.placeholder.com/150');
            $actualite->setChocolaterie($this->getReference("chocolaterie_".$i));
            $manager->persist($actualite);

        }
            $manager->flush();

    }

    public function getDependencies()
    {
        return array(
            ChocolaterieFixtures::class,
        );
    }
}
