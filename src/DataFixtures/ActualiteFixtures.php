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
            $actualite->setContenu("Ceci est le contenu d'un article");
            $actualite->setCratedAt(new \DateTimeImmutable());
            $actualite->setImageActu('https://via.placeholder.com/150');
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
