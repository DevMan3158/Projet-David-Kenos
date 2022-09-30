<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/*use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\String\Slugger\SluggerInterface;*/


#[Route('/')]
class UserProfilController extends AbstractController
{


   #[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
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
        ]);



        /*#[Route('user/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
        public function edit(Request $request, FileUploader $fileUploader ,SluggerInterface $slugger ,User $user, Int $id, UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository): Response
        {
            $form = $this->createForm(User1Type::class, $user);
            $form->handleRequest($request);*/
    
            /*if ($form->isSubmitted() && $form->isValid()) {*/
                
               /* $userRepository->add($user, true);
                $image_bandeau = $form->get('ImageBandeau')->getData();*/
    
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                /*if ($image_bandeau) {
                    $image_bandeauName = $fileUploader->upload($image_bandeau);
                    $user->setImageBandeau($image_bandeauName);*/
    
                    // Move the file to the directory where brochures are stored
                    /*try {
                        $image_bandeau->move(
                            $this->getParameter('data'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    $user->setImageBandeau($newFilename);*/
               /* }
                return $this->redirectToRoute('app_mon_profil', [], Response::HTTP_SEE_OTHER);
            }
    
            return $this->renderForm('user_profil/edit.html.twig', [
                'user' => $user,
                'form' => $form,
            ]);*/


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
