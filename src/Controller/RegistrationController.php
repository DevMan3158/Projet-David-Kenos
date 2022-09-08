<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ChocolaterieRepository;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user/*, array('chocolaterie' => $chocolaterie->findAll())*/);

        $tableChocolateries=[
            ['nom' => 'Chocolaterie du ministral', 'lieu' => 'Marzy'],
            ['nom' => 'Chocolaterie du chocolat','lieu' => 'Nevers'],
            ['nom' => 'Chocolaterie du fondant','lieu' => 'La Charité'],
            ['nom' => 'Chocolaterie du croustillant','lieu' => 'Pougues-les-eaux'],
            ['nom' => 'Chocolaterie du palpitant','lieu' => 'Sancerre'],
        ];


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setImageProfil('https://via.placeholder.com/150');
            $user->setImageProfilAlt('https://via.placeholder.com/150');
            $user->setImageBandeau('https://via.placeholder.com/150');
            $user->setImageBandeauAlt('https://via.placeholder.com/150');
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setRoles(["ROLE_USER"]);


            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'tableChocolateries' => $tableChocolateries,
        ]);
    }
}
