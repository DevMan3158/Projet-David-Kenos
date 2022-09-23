<?php

namespace App\Controller;

use App\Entity\Chocolaterie;
use App\Form\ChocolaterieType;
use App\Repository\ChocolaterieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/chocolaterie')]
class ChocolaterieController extends AbstractController
{
    #[Route('/', name: 'app_chocolaterie_index', methods: ['GET'])]
    public function index(ChocolaterieRepository $chocolaterieRepository): Response
    {
        return $this->render('admin/chocolaterie/index.html.twig', [
            'chocolateries' => $chocolaterieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chocolaterie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChocolaterieRepository $chocolaterieRepository): Response
    {
        $chocolaterie = new Chocolaterie();
        $form = $this->createForm(ChocolaterieType::class, $chocolaterie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chocolaterieRepository->add($chocolaterie, true);

            return $this->redirectToRoute('app_chocolaterie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/chocolaterie/new.html.twig', [
            'chocolaterie' => $chocolaterie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chocolaterie_show', methods: ['GET'])]
    public function show(Chocolaterie $chocolaterie): Response
    {
        return $this->render('admin/chocolaterie/show.html.twig', [
            'chocolaterie' => $chocolaterie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chocolaterie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chocolaterie $chocolaterie, ChocolaterieRepository $chocolaterieRepository): Response
    {
        $form = $this->createForm(ChocolaterieType::class, $chocolaterie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chocolaterieRepository->add($chocolaterie, true);

            return $this->redirectToRoute('app_chocolaterie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/chocolaterie/edit.html.twig', [
            'chocolaterie' => $chocolaterie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chocolaterie_delete', methods: ['POST'])]
    public function delete(Request $request, Chocolaterie $chocolaterie, ChocolaterieRepository $chocolaterieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chocolaterie->getId(), $request->request->get('_token'))) {
            $chocolaterieRepository->remove($chocolaterie, true);
        }

        return $this->redirectToRoute('app_chocolaterie_index', [], Response::HTTP_SEE_OTHER);
    }
}
