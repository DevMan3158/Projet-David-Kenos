<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use App\Form\UserType;
use App\Entity\CatPost;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\PostRepository;
use App\Repository\CatPostRepository;
use Doctrine\ORM\PersistentCollection;
use App\Repository\CommentaireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

class MonProfilController extends AbstractController
{


    #[Route('utilisateur/profil/{id}', name: 'app_profil', methods:['GET', 'POST']) ]
    
    public function profil(Post $posts, Request $request, $id, User $user, CatPostRepository $catPostRepository, CommentaireRepository $commentaireRepository ,PostRepository $post, Like $like, Commentaire $commentaire ): Response
{
    //$commentaire = $commentaireRepository->findAll($post);

    //On appel l'entité commentaire
    $commentaire = new Commentaire();
    //On appel le formulaire 
    $form = $this->createForm(CommentaireType::class, $commentaire);
    
    $form->handleRequest($request);

    //On remplie les champs non null 
    $commentaire->setCreatedAt(new \DateTimeImmutable());
    $userId = $this->getUser();
    $commentaire->setUser($userId);
    $commentaire->setPost($posts);

    if ($form->isSubmitted() && $form->isValid()) {
        $commentaireRepository->add($commentaire, true);
        
    }

    return $this->renderForm('user/profil_view/index.html.twig', [
        'commentaire' => $commentaire,
        'form' => $form,
        "post"=> $post->findByUser($user),
        "com" => $commentaireRepository->findByUser($user),
        "user"=> $user,

    ]);

    
}


/*#[Route('utilisateur/profil/{id}', name: 'app_profil', methods: ['POST'])]
public function delete(Request $request, Commentaire $commentaire, CommentaireRepository $commentaireRepository): Response
{
    if ($this->isCsrfTokenValid('delete'.$commentaire->getId(), $request->request->get('_token'))) {
        $commentaireRepository->remove($commentaire, true);
    }
}*/


}