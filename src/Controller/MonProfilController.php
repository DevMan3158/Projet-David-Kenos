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
    /*//$commentaire = $commentaireRepository->findAll($post);
    $postCom = ($_GET["idPost"]);
    //On appel l'entité commentaire
    $commentaire = new Commentaire();
    //On appel le formulaire 
    $form = $this->createForm(CommentaireType::class, $commentaire);
    
    $form->handleRequest($request);
    $userId = $this->getUser();

    //On remplie les champs non null 
    $commentaire->setCreatedAt(new \DateTimeImmutable());
    $commentaire->setUser($userId);
    $commentaire->setPost(($_GET["idPost"]));

    if ($form->isSubmitted() && $form->isValid()) {
        $commentaireRepository->add($commentaire, true);
    }*/

        // PAGINATION

        // On stocke la page actuelle dans une variable

        $currentPage = (int)$request->query->get("pg", 1);

        // On détermine le nombre d'articles par page

        $perPage = 3;

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;
                
        // On récupère le nombre d'articles et on compte le nombre de pages et on arrondi à l'entier suppérieur

        $page = ceil(count($post->findByUser($user)) / $perPage);

        // On définis les articles à afficher en fonction de la page
        //$userId = $user->getId();

        $postPerPage = $post->postPaginateUser($perPage, $firstObj, $user);

    return $this->renderForm('user/profil_view/index.html.twig', [
        'commentaire' => $commentaire,
        //'form' => $form,
        "post"=> $postPerPage,
        "com" => $commentaireRepository->findByUser($user),
        "user"=> $user,
        "pages"=> $page,
        "currentPage"=>$currentPage,

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