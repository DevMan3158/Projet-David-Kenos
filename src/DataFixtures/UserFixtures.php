<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\Entity\Chocolaterie;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ChocolaterieFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class UserFixtures extends Fixture implements DependentFixtureInterface
{
    //Ajout d'une fonction pour le haché le mot de passe 
    public const CHOCOLATERIE_REFERENCE = 'user-robin';
    public function __construct(
    private UserPasswordHasherInterface $passwordEncoder,
    ){}

    /*public const USER_REFERENCE = 'user-gary';*/
    public function load(ObjectManager $manager): void
    {


        //Tableau

        $tableUser=[
        ['nom' => 'Kenos', 'prenom' =>'David' ,'poste' => 'Gérant des chocolateries','email' => 'David.Kenos@gmail.fr', 'roles' => ["ROLE_SUPER_ADMIN"], 'chocolaterie' => 1 ],
        ['nom' => 'Alebat', 'prenom' =>'Evelyne ' ,'poste' => 'Chargée de clientèle ','email' => 'Evelyne.Alebat@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 1  ],
        ['nom' => 'Allemand', 'prenom' =>'Arthur' ,'poste' => 'Gérant','email' => 'Arthur.Allemand@gmail.fr', 'roles' => ["ROLE_ADMIN"], 'chocolaterie' => 2  ],
        ['nom' => 'Mylenas', 'prenom' =>'Romain' ,'poste' => 'Chargé de clientèle','email' => 'Romain.Mylenas@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 1  ],
        ['nom' => 'Ousbema', 'prenom' =>'Sukaina' ,'poste' => 'Chocolatière','email' => 'Sukaina.Ousbema@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 3  ],
        ['nom' => 'Treik', 'prenom' =>'Eliott' ,'poste' => 'Chocolatier ','email' => 'Eliott.Treik@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 1  ],
        ['nom' => 'Raoul', 'prenom' =>'Marvin' ,'poste' => 'Chocolatier ','email' => 'Marvin.Raoul@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 2  ],
        ['nom' => 'Espinosa', 'prenom' =>'Leslie' ,'poste' => 'Chocolatière','email' => 'leslie.espinosa@gmail.com', 'roles' => ['ROLE_USER'], 'chocolaterie' => 4  ],
        ['nom' => 'Chevallier', 'prenom' =>'Louis' ,'poste' => 'Chocolatier','email' => 'louis.chevalier@gmail.com', 'roles' => ['ROLE_USER'], 'chocolaterie' => 0  ],
        ['nom' => 'Riviere', 'prenom' =>'Anthony' ,'poste' => 'Gérant','email' => 'anthony.riviere@gmail.com', 'roles' => ['ROLE_ADMIN'], 'chocolaterie' => 1 ],
        
        
        ];

        for ($i=0; $i < 10 ; $i++) { 
            
        $user = new User();

        $user->setNom($tableUser[$i]['nom']);
        $user->setPrenom($tableUser[$i]['prenom']);
        $user->setPoste($tableUser[$i]['poste']);
        $user->setEmail($tableUser[$i]['email']);
        $user->setRoles($tableUser[$i]['roles']);



        $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'secret'));
            
            
        $user->setDescription('');   
        $user->setLinkedin('');
        $user->setFacebook('');    
        $user->setInstagram('');     
        $user->setTwitter('');      
        $user->setLien('');   
        $user->setImageProfil("https://via.placeholder.com/150");  
        $user->setImageProfilAlt("https://via.placeholder.com/150");  
        $user->setImageBandeau("https://via.placeholder.com/1080x460");  
        $user->setImageBandeauAlt("https://via.placeholder.com/1080x460");
        $user->setCreatedAt(new \DatetimeImmutable());
        $user->setChocolaterie($this->getReference("chocolaterie_".$tableUser[$i]['chocolaterie']));
        $this->addReference('user_'.$i, $user);

        
        //$this->addReference(self::USER_REFERENCE, $user);
        
        $manager->persist($user);
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