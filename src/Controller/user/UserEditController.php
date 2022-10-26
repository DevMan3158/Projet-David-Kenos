<?php

namespace App\Controller\user;

use App\Entity\User;
use App\Form\EditUserType;
use App\Service\FileUploader;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/')]
class UserEditController extends AbstractController
{

        #[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
        public function edit(UserPasswordHasherInterface $userPasswordHasher, FileUploader $fileUploader, Request $request, User $user, Int $id, UserRepository $userRepository): Response
        {

            $userId = $this->getUser()->getId();
            if ($userId !== $id) {

                return $this->redirectToRoute('app_profil',['id' => $id], Response::HTTP_SEE_OTHER);
                
            }
        
        //Création du formulaire EditUserType
            $form = $this->createForm(EditUserType::class, $user);

            $form->handleRequest($request);
        //Cette condition est nécessaire pour les champs du formulaire 
        if ($form->isSubmitted() && $form->isValid()) 
        {

            //Récupère les différentes données du formulaire

            $imageFile = $form->get('ImageBandeau')->getData();
            $imageFilePro = $form->get('ImageProfil')->getData();
            $password = $form->get('plainPassword')->getData();

            if (!empty($password)) {

                //Permet de changer le mdp -> hash le mdp 

                $encodedPassword = $userPasswordHasher->hashPassword($user, $password);
                $user->setPassword($encodedPassword);
            }

            //Cette condition est nécessaire car le champ 'ImageBandeau' n'est pas obligatoire
            //Donc le fichier doit être traité uniquement lorsqu'il est téléchargé et non vide 

            if (!empty($imageFile)) {
                   $imageFileName = $fileUploader->upload($imageFile);
                   $user->setImageBandeau('../data/'. $imageFileName);
                   //Met à jour la propriété 'setImageBandeau' pour stocker le nom du fichier et sa concaténation (chemin du fichier) 
               }

               //Conditionne dans le cas d'un changement de l'image du profile 
            if (!empty($imageFilePro)) {
                   $imageFileNamePro = $fileUploader->upload($imageFilePro);
                   $user->setImageProfil('../data/'. $imageFileNamePro);
               }

                $userRepository->add($user, true);
                return $this->redirectToRoute('app_user_profil_edit',['id' => $id], Response::HTTP_SEE_OTHER);

            }
    
            return $this->renderForm('user_profil/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);

    }


    #[Route('/{id}', name: 'app_user_profil_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            //si token null redirige vers register 
            $this->container->get('security.token_storage')->setToken(null);
            $userRepository->remove($user, true);
        }

        $this->addFlash('deleted','Votre compte a été supprimé.');
        return $this->redirectToRoute('app_register');
    }
}
