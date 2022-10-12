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
            ['nom' => 'Chocolaterie du ministral', 'lieu' => 'Marzy', 'photo' => 'img/chocolaterie/choc1.jpg'],
            ['nom' => 'Chocolaterie du chocolat','lieu' => 'Nevers', 'photo' => 'img/chocolaterie/choc2.jpg'],
            ['nom' => 'Chocolaterie du fondant','lieu' => 'La Charité', 'photo' => 'img/chocolaterie/choc3.jpg'],
            ['nom' => 'Chocolaterie du croustillant','lieu' => 'Pougues-les-eaux', 'photo' => 'img/chocolaterie/choc4.jpg'],
            ['nom' => 'Chocolaterie du palpitant','lieu' => 'Sancerre', 'photo' => 'img/chocolaterie/choc5.jpg'],
        ];

        for ($i = 0; $i < 5; $i++) {

            $chocolaterie = new Chocolaterie();
            $chocolaterie->setNom($tableChocolateries[$i]['nom']);
            $chocolaterie->setLieu($tableChocolateries[$i]['lieu']);
            $chocolaterie->setPhoto($tableChocolateries[$i]['photo']);
            $chocolaterie->setDescription('Ceci est la description de la chocolaterie, cette chocolaterie fabrique du tres bon chocolat blablabliblablabla');
            $this->addReference('chocolaterie_'.$i, $chocolaterie);
            $manager->persist($chocolaterie);

        }

        $manager->flush();

    }
}