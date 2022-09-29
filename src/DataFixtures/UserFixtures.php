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

        ['nom' => 'Kenos', 'prenom' =>'David' ,'poste' => 'Gérant des chocolateries','email' => 'David.Kenos@gmail.fr', 'roles' => ["ROLE_SUPER_ADMIN"], 'chocolaterie' => 1 ,'ImageProfil'=>'../img/profils/david_kenos/david-kenos-child.jpeg','ImageBandeau'=>'../img/profils/david_kenos/gateau-chocolats.jpeg'],

        ['nom' => 'Alebat', 'prenom' =>'Evelyne ' ,'poste' => 'Chargée de clientèle ','email' => 'Evelyne.Alebat@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 1  ,'ImageProfil'=>'../img/profils/evelyne_alebat/woman-blond-smile.jpeg','ImageBandeau'=>'../img/profils/evelyne_alebat/paysage-montagne-bandeau.jpeg'],

        ['nom' => 'Allemand', 'prenom' =>'Arthur' ,'poste' => 'Gérant','email' => 'Arthur.Allemand@gmail.fr', 'roles' => ["ROLE_ADMIN"], 'chocolaterie' => 2  ,'ImageProfil'=>'../img/profils/arthur_allemand/arthur-allemand-homme.jpeg','ImageBandeau'=>'../img/profils/arthur_allemand/cities-skyline.jpeg'],

        ['nom' => 'Mylenas', 'prenom' =>'Romain' ,'poste' => 'Chargé de clientèle','email' => 'Romain.Mylenas@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 1  ,'ImageProfil'=>'../img/profils/romain_mylenas/romain-mylenas-chemise.jpeg','ImageBandeau'=>'../img/profils/romain_mylenas/ville-mer-montagne.jpeg'],

        ['nom' => 'Ousbema', 'prenom' =>'Sukaina' ,'poste' => 'Chocolatière','email' => 'Sukaina.Ousbema@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 3  ,'ImageProfil'=>'../img/profils/sukaina_ousbema/sukaina-ousbema-femme.jpeg','ImageBandeau'=>'../img/profils/sukaina_ousbema/flowers-pink-butterfly.jpeg'],

        ['nom' => 'Treik', 'prenom' =>'Eliott' ,'poste' => 'Chocolatier ','email' => 'Eliott.Treik@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 1  ,'ImageProfil'=>'../img/profils/eliott_treik/man-lunettes.jpeg','ImageBandeau'=>'../img/profils/eliott_treik/fleurs-oranges-rose.jpeg'],

        ['nom' => 'Raoul', 'prenom' =>'Marvin' ,'poste' => 'Chocolatier ','email' => 'Marvin.Raoul@gmail.fr', 'roles' => ["ROLE_USER"], 'chocolaterie' => 2  ,'ImageProfil'=>'../img/profils/marvin_raoul/homme-lumieres.jpeg','ImageBandeau'=>'../img/profils/marvin_raoul/panorama-landscape.jpeg'],

        ['nom' => 'Espinosa', 'prenom' =>'Leslie' ,'poste' => 'Chocolatière','email' => 'leslie.espinosa@gmail.com', 'roles' => ['ROLE_USER'], 'chocolaterie' => 4  ,'ImageProfil'=>'../img/profils/leslie_espinosa/femme-chapeau.jpeg','ImageBandeau'=>'../img/profils/leslie_espinosa/island.jpeg'],

        ['nom' => 'Chevallier', 'prenom' =>'Louis' ,'poste' => 'Chocolatier','email' => 'louis.chevalier@gmail.com', 'roles' => ['ROLE_USER'], 'chocolaterie' => 0  ,'ImageProfil'=>'../img/profils/louis_chevallier/homme-jeune.jpeg','ImageBandeau'=>'../img/profils/louis_chevallier/city-skyline-homme.jpeg'],

        ['nom' => 'Riviere', 'prenom' =>'Anthony' ,'poste' => 'Gérant','email' => 'anthony.riviere@gmail.com', 'roles' => ['ROLE_ADMIN'], 'chocolaterie' => 1 ,'ImageProfil'=>'../img/profils/anthony_riviere/anthony-riviere.jpg','ImageBandeau'=>'../img/profils/anthony_riviere/foret-bandeau-profil.jpeg'],

        ];

        for ($i=0; $i < 10 ; $i++) { 
            
        $user = new User();

        $user->setNom($tableUser[$i]['nom']);
        $user->setPrenom($tableUser[$i]['prenom']);
        $user->setPoste($tableUser[$i]['poste']);
        $user->setEmail($tableUser[$i]['email']);
        $user->setRoles($tableUser[$i]['roles']);
        $user->setImageProfil($tableUser[$i]['ImageProfil']);
        $user->setImageBandeau($tableUser[$i]['ImageBandeau']);


        $user->setPassword(
            $this->passwordEncoder->hashPassword($user, 'secret'));
            
            
        $user->setDescription('Lorem ipsum dolor sit amet consectetur adipisicing elit.Aspernatur nostrum aut, voluptates laudantium minima voluptas dolor pariatur unde veritatis, similique eius. Laboriosam molestiae consequuntur facere. Dolorum maiores odio repellendus voluptate!');   
        $user->setFacebook('https://fr-fr.facebook.com/');    
        $user->setInstagram('https://www.instagram.com/?hl=fr');     
        $user->setTwitter('https://twitter.com/?lang=fr');      
        $user->setLinkedin('https://fr.linkedin.com/');
        $user->setLien('https://github.com/');   
        $user->setImageProfilAlt("https://via.placeholder.com/150");    
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