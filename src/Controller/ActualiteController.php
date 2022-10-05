<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Entity\Chocolaterie;
use App\Form\ChocolaterieType;
use App\Repository\ChocolaterieRepository;
use App\Repository\ActualiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/actualite')]
class ActualiteController extends AbstractController
{
    #[Route('/', name: 'app_actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository,  ChocolaterieRepository $chocolaterieRepository): Response
    {
        // On détermine sur quelle page on se trouve

                if(!empty($_GET['pg'])){
                    $currentPage = (int) strip_tags($_GET['pg']);
                } else {
                    $currentPage = 1;
                }
        
                // On détermine le nombre d'actus total
        
                $nbAct = $actualiteRepository->countAct();
        
                // On détermine le nombre d'articles par page
        
                $perPage = 5;
        
                // On calcule le nombre de page total
        
                $page = ceil($nbAct / $perPage);
        
                // Calcul du premier article de la page
        
                $firstObj = ($currentPage * $perPage) - $perPage;
        
                $actPerPage = $actualiteRepository->findAllAct($perPage, $firstObj);
        
        return $this->render('admin/actualite/index.html.twig', [
            'actualites' => $actPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/new', name: 'app_actualite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ActualiteRepository $actualiteRepository, ChocolaterieRepository $chocolaterieRepository ): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->add($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/actualite/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actualite_show', methods: ['GET'])]
    public function show(Actualite $actualite, ChocolaterieRepository $chocolaterieRepository): Response
    {
        return $this->render('admin/actualite/show.html.twig', [
            'actualite' => $actualite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_actualite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository,  ChocolaterieRepository $chocolaterieRepository): Response
    {

        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $actualiteRepository->add($actualite, true);

            return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/actualite/edit.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_actualite_delete', methods: ['POST'])]
    public function delete(Request $request, Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$actualite->getId(), $request->request->get('_token'))) {
            $actualiteRepository->remove($actualite, true);
        }

        return $this->redirectToRoute('app_actualite_index', [], Response::HTTP_SEE_OTHER);
    }
}
