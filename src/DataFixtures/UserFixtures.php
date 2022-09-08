<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\DataFixtures\ChocolaterieFixtures;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;



class UserFixtures extends Fixture
{
    //Ajout d'une fonction pour le haché le mot de passe 
    public function __construct(
    private UserPasswordHasherInterface $passwordEncoder,
    ){
        
    }

    /*public const USER_REFERENCE = 'user-gary';*/
    public function load(ObjectManager $manager)
    {


        //Tableau

        $tableUser=[
        ['nom' => 'Kenos', 'prenom' =>'David' ,'poste' => 'Gérant des chocolateries','email' => 'David.Kenos@gmail.fr', 'roles' => ["ROLE_SUPER_ADMIN"] ],
        ['nom' => 'Alebat', 'prenom' =>'Evelyne ' ,'poste' => 'Chargée de clientèle ','email' => 'Evelyne.Alebat@gmail.fr', 'roles' => ["ROLE_USER"] ],
        ['nom' => 'Allemand', 'prenom' =>'Arthur' ,'poste' => 'Gérant','email' => 'Arthur.Allemand@gmail.fr', 'roles' => ["ROLE_ADMIN"] ],
        ['nom' => 'Mylenas', 'prenom' =>'Romain' ,'poste' => 'Chargé de clientèle','email' => 'Romain.Mylenas@gmail.fr', 'roles' => ["ROLE_USER"] ],
        ['nom' => 'Ousbema', 'prenom' =>'Sukaina' ,'poste' => 'Chocolatière','email' => 'Sukaina.Ousbema@gmail.fr', 'roles' => ["ROLE_USER"] ],
        ['nom' => 'Treik', 'prenom' =>'Eliott' ,'poste' => 'Chocolatier ','email' => 'Eliott.Treik@gmail.fr', 'roles' => ["ROLE_USER"] ],
        ['nom' => 'Raoul', 'prenom' =>'Marvin' ,'poste' => 'Chocolatier ','email' => 'Marvin.Raoul@gmail.fr', 'roles' => ["ROLE_USER"] ],
        ['nom' => 'Espinosa', 'prenom' =>'Leslie' ,'poste' => 'Chocolatière','email' => 'leslie.espinosa@gmail.com', 'roles' => ['ROLE_USER'] ],
        ['nom' => 'Chevallier', 'prenom' =>'Louis' ,'poste' => 'Chocolatier','email' => 'louis.chevalier@gmail.com', 'roles' => ['ROLE_USER'] ],
        ['nom' => 'Riviere', 'prenom' =>'Anthony' ,'poste' => 'Gérant','email' => 'anthony.riviere@gmail.com', 'roles' => ['ROLE_ADMIN']],
        
        
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
            
            
        $user->setDescription(" ");   
        $user->setLinkedin(" ");
        $user->setFacebook(" ");    
        $user->setInstagram(" ");     
        $user->setTwitter(" ");      
        $user->setLien(" ");   
        $user->setImageProfil("https://via.placeholder.com/150");  
        $user->setImageProfilAlt("https://via.placeholder.com/150");  
        $user->setImageBandeau("https://via.placeholder.com/1080x460");  
        $user->setImageBandeauAlt("https://via.placeholder.com/1080x460");
        $user->setCreatedAt(new \DatetimeImmutable());
        $user->setChocolaterie('Chocolaterie du chocolat');


        
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