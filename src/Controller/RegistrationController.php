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
    #[Route('/inscription', name: 'app_register')]
    //Route pour accéder au formulaire admin 
    #[Route('/inscription/admin', name: 'app_register_admin')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $routeName = $request->attributes->get('_route');
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setImageProfil('../img/profils/default/Cranks-1.png');
            $user->setImageProfilAlt('Image de profil sans genre, de couleur de peau orange avec un oeil bleu et des cheveux bleu sur fond bleu-ciel');
            $user->setImageBandeau('../img/profils/default/pexels-rovenimagescom-949587.jpg');
            $user->setImageBandeauAlt('Fond blanc lumineux');
            $user->setCreatedAt(new \DateTimeImmutable());

            if($routeName == "app_register_admin"){
                $user->setRoles(["ROLE_ADMIN"]);
            } else if ($routeName == "app_register"){
                $user->setRoles(["ROLE_USER"]);
            }


            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
            'request' => $routeName,
        ]);
    }


}
