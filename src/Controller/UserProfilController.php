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

        #[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
        public function edit(EntityManagerInterface $em, Request $request ,SluggerInterface $slugger, User $user, Int $id, UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository): Response
        {

            $form = $this->createForm(User1Type::class, $user);

            $form->handleRequest($request);
    
        //  cette condition est nécessaire pour les champs du formulaire hors Upload

        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $userRepository->add($user, true);

            /** @var UploadedFile $imageFile */

            //Récupère la donnée du champs ImageBandeau du usertype et le stoke
            $imageFile = $form->get('ImageBandeau')->getData();

            //Récupère la donnée du champs ImageProfil du usertype et le stoke
            $imageFilePro = $form->get('ImageProfil')->getData();

            //Cette condition est nécessaire car le champ 'ImageBandeau' n'est pas obligatoire
            //
            //Donc le fichier doit être traité uniquement lorsqu'un fichier est téléchargé
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                
            //Ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
                $safeFilename = $slugger->slug($originalFilename);
                
            //On indique le chemin du fichier pour l'enregistrement dans la bdd et donne un id unique au fichier  
                $newFilename = '../data/'.$safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            /* Définit data_directory dans le fichier service.yaml    
               Déplace le fichier dans le répertoire où sont stockées les fichiers*/
                try {
                    
                    $imageFile->move($this->getParameter('data_directory'),$newFilename);

            //Gérer l'exception si quelque chose se passe pendant le téléchargement du fichier
                } catch (FileException $e) {
                    
                }

            //Met à jour la propriété 'setImageBandeau' pour stocker le nom du fichier 
            $user->setImageBandeau($newFilename);

            }

            //Conditionne dans le cas d'un changement de l'image de profile 
            elseif ($imageFilePro) {
                $originalFilename = pathinfo($imageFilePro->getClientOriginalName(), PATHINFO_FILENAME);
                
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = '../data/'.$safeFilename.'-'.uniqid().'.'.$imageFilePro->guessExtension();
                try {
                    
                    $imageFilePro->move($this->getParameter('data_directory'),$newFilename);

                } catch (FileException $e) {
                    
                }

            $user->setImageProfil($newFilename);
            }

            // Persiste la variable $user ou tout autre travail
            $em->persist($user);

            // Hydrate la bdd
            $em->flush();

                $this->addFlash('success', 'Leaderboard modifié');
                //return $this->redirectToRoute('app_mon_profil',['id' => $id], Response::HTTP_SEE_OTHER);
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
