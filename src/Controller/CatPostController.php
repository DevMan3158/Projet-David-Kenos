<?php

namespace App\Controller;

use App\Entity\CatPost;
use App\Form\CatPostType;
use App\Repository\CatPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/cat/post')]
class CatPostController extends AbstractController
{
    #[Route('/', name: 'app_cat_post_index', methods: ['GET'])]
    public function index(CatPostRepository $catPostRepository): Response
    {
        return $this->render('admin/cat_post/index.html.twig', [
            'cat_posts' => $catPostRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cat_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CatPostRepository $catPostRepository): Response
    {
        $catPost = new CatPost();
        $form = $this->createForm(CatPostType::class, $catPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catPostRepository->add($catPost, true);

            return $this->redirectToRoute('app_cat_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cat_post/new.html.twig', [
            'cat_post' => $catPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cat_post_show', methods: ['GET'])]
    public function show(CatPost $catPost): Response
    {
        return $this->render('admin/cat_post/show.html.twig', [
            'cat_post' => $catPost,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cat_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CatPost $catPost, CatPostRepository $catPostRepository): Response
    {
        $form = $this->createForm(CatPostType::class, $catPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $catPostRepository->add($catPost, true);

            return $this->redirectToRoute('app_cat_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cat_post/edit.html.twig', [
            'cat_post' => $catPost,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cat_post_delete', methods: ['POST'])]
    public function delete(Request $request, CatPost $catPost, CatPostRepository $catPostRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$catPost->getId(), $request->request->get('_token'))) {
            $catPostRepository->remove($catPost, true);
        }

        return $this->redirectToRoute('app_cat_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
