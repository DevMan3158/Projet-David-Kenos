<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class UserProfilController extends AbstractController
{


    #[Route('/{id}', name: 'app_user_profil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, Int $id, UserRepository $userRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $userRepository->add($user, true);
            //Permet de raffraichir la même page 
            $user = $userRepository->find($id);

            //Récupère l'id dans id et l'intègre à la route 
            return $this->redirectToRoute('app_user_profil_edit', ['id' => $id], Response::HTTP_SEE_OTHER);
            
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
