<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\CatPost;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\CatPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, CatPostRepository  $catPostRepository, Request $request): Response
    {
     // On détermine sur quelle page on se trouve

     if(!empty($_GET['pg'])){
        $currentPage = (int) strip_tags($_GET['pg']);
    } else {
        $currentPage = 1;
    }

    // On détermine le nombre de posts total

    $nbPost = $postRepository->countPost();

    // On détermine le nombre d'articles par page

    $perPage = 5;

    // On calcule le nombre de page total

    $page = ceil($nbPost / $perPage);

    // Calcul du premier article de la page

    $firstObj = ($currentPage * $perPage) - $perPage;

    $postPerPage = $postRepository->findAllPost($perPage, $firstObj);

    return $this->render('admin/post/index.html.twig', [
        

        //$post = $postRepository->find(),
        'posts' => $postPerPage,
        'pages' => $page,
        'currentPage' => $currentPage,
    ]);

    }

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('admin/post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->add($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
