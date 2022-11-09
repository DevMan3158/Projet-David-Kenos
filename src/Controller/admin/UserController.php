<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\adminCrud\UserType;
use App\Repository\UserRepository;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/user')]
class UserController extends AbstractController
{
    
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository, Request $request): Response
    {

        // On détermine sur quelle page on se trouve

        if(!empty($_GET['pg'])){
            $currentPage = (int) strip_tags($_GET['pg']);
        } else {
            $currentPage = 1;
        }

        // On détermine le nombre d'users total

        $nbUser = $userRepository->countUser();

        // On détermine le nombre d'articles par page

        $perPage = 5;

        // On calcule le nombre de page total

        $page = ceil($nbUser / $perPage);

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;

        $userPerPage = $userRepository->findAllWithChoco($perPage, $firstObj);

        return $this->render('admin/user/index.html.twig', [
            'users' => $userPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
        ]);
    }


    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'users' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, ChocolaterieRepository $chocolaterieRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
