<?php

namespace App\DataFixtures;


use App\Entity\Chocolaterie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ChocolaterieFixtures extends Fixture
{
    public const CHOCOLATERIE_REFERENCE = 'user-robin';
    public function load(ObjectManager $manager): void
    {

        $tableChocolateries=[
            ['nom' => 'Chocolaterie du ministral', 'lieu' => 'Marzy'],
            ['nom' => 'Chocolaterie du chocolat','lieu' => 'Nevers'],
            ['nom' => 'Chocolaterie du fondant','lieu' => 'La Charité'],
            ['nom' => 'Chocolaterie du croustillant','lieu' => 'Pougues-les-eaux'],
            ['nom' => 'Chocolaterie du palpitant','lieu' => 'Sancerre'],
        ];

        for ($i = 0; $i < 5; $i++) {

            $chocolaterie = new Chocolaterie();
            $chocolaterie->setNom($tableChocolateries[$i]['nom']);
            $chocolaterie->setLieu($tableChocolateries[$i]['lieu']);
            $this->addReference('user_'.$i, $chocolaterie);
            $manager->persist($chocolaterie);

        }

        $manager->flush();

    }
}
