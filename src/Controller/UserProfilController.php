<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
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


#[Route('/')]
class UserProfilController extends AbstractController
{


   /* #[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, Int $id, UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $userRepository->add($user, true);
            //Permet de raffraichir la même page 
           // $user = $userRepository->find($id);


            //Récupère l'id dans id et l'intègre à la route 
           // return $this->redirectToRoute('app_mon_profil', ['id' => $id], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_mon_profil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_profil/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);*/



        #[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
        public function edit(Request $request ,SluggerInterface $slugger, EntityManagerInterface $entityManager,User $user, Int $id, UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository): Response
        {
            $form = $this->createForm(User1Type::class, $user);
            $form->handleRequest($request);
    

            //  cette condition est nécessaire pour les champs du formulaire hors fichier

        if ($form->isSubmitted() && $form->isValid()) 
        {

            $userRepository->add($user, true);

            /** @var UploadedFile $imageFile */

            $imageFile = $form->get('ImageBandeau')->getData();

            // cette condition est nécessaire car le champ 'ImageBandeau' n'est pas obligatoire

            // donc le fichier doit être traité uniquement lorsqu'un fichier est téléchargé
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
            // ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            /* Définit data_directory dans le fichier service.yaml    

             Déplace le fichier dans le répertoire où sont stockées les images*/
                try {
                    $imageFile->move(
                        $this->getParameter('data_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    
            // ... gérer l'exception si quelque chose se passe pendant le téléchargement du fichie
                }

                
            // met à jour la propriété 'setImageBandeau' pour stocker le nom du fichier PDF
            // au lieu de son contenu
                $user->setImageBandeau($newFilename);
            }

            // ... persister la variable $user ou tout autre travail

                $this->addFlash('success', 'Photo modifié');
                return $this->redirectToRoute('app_mon_profil', [], Response::HTTP_SEE_OTHER);
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
