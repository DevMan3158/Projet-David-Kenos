<?php

namespace App\DataFixtures;


use App\Entity\Actualite;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ActualiteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

            $actualite = new Actualite();
            $actualite->setContenu("Ceci est le contenu d'un article");
            $actualite->setCreatedAt(new \DateTimeImmutable());
            $actualite->setImageActu('https://via.placeholder.com/150');
            $actualite->setImageActuAlt('https://via.placeholder.com/150');
            $actualite->setChocolaterie();
            $manager->persist($actualite);
            $manager->flush();

    }
}
