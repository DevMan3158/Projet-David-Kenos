<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[Route('/')]
class UserProfilController extends AbstractController
{

        #[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
        public function edit(UserPasswordHasherInterface $userPasswordHasher, FileUploader $fileUploader, EntityManagerInterface $em, Request $request ,SluggerInterface $slugger, User $user, Int $id, UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository): Response
        {
        
        //Création du formulaire User1Type
            $form = $this->createForm(User1Type::class, $user);

            $form->handleRequest($request);
    
        //Cette condition est nécessaire pour les champs du formulaire 
        if ($form->isSubmitted() && $form->isValid()) 
        {
            //Permet de changer le mdp -> hash le mdp 
            $encodedPassword = $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
                )
            ;
            //Appel du repos user 
            $userRepository->add($user, true);

            /** @var UploadedFile $imageFile */

            //Récupère la donnée du champs ImageBandeau du usertype et le stoke
            $imageFile = $form->get('ImageBandeau')->getData();

            ////Récupère la donnée du champs ImageProfil du usertype et le stoke
            $imageFilePro = $form->get('ImageProfil')->getData();
            
            //Cette condition est nécessaire car le champ 'ImageBandeau' n'est pas obligatoire
            //Donc le fichier doit être traité uniquement lorsqu'il est téléchargé et non vide 

               if (!empty($imageFile)) {

                   $imageFileName = $fileUploader->upload($imageFile);
                   //Met à jour la propriété 'setImageBandeau' pour stocker le nom du fichier et sa concaténation (chemin du fichier) 
                   $user->setImageBandeau('../data/'. $imageFileName);
               }

               //Conditionne dans le cas d'un changement de l'image du profile 
               elseif (!empty($imageFilePro)) {

                   $imageFileName = $fileUploader->upload($imageFilePro);
                   $user->setImageProfil('../data/'. $imageFileName);
               }


            //transmet le mdp
            $user->setPassword($encodedPassword);

            // Persiste la variable $user ou tout autre travail
            $em->persist($user);

            // Hydrate la bdd
            $em->flush();

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
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_register', [], Response::HTTP_SEE_OTHER);
    }
}
