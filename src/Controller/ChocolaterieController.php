<?php

namespace App\Controller;

use App\Entity\Chocolaterie;
use App\Service\FileUploader;
use App\Form\ChocolaterieType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('admin/chocolaterie')]
class ChocolaterieController extends AbstractController
{
    #[Route('/', name: 'app_chocolaterie_index', methods: ['GET'])]
    public function index(ChocolaterieRepository $chocolaterieRepository): Response
    {

                // On détermine sur quelle page on se trouve

                if(!empty($_GET['pg'])){
                    $currentPage = (int) strip_tags($_GET['pg']);
                } else {
                    $currentPage = 1;
                }
        
                // On détermine le nombre d'users total
        
                $nbChoc = $chocolaterieRepository->countChoco();
        
                // On détermine le nombre d'articles par page
        
                $perPage = 5;
        
                // On calcule le nombre de page total
        
                $page = ceil($nbChoc / $perPage);
        
                // Calcul du premier article de la page
        
                $firstObj = ($currentPage * $perPage) - $perPage;
        
                $chocPerPage = $chocolaterieRepository->findAllChoco($perPage, $firstObj);
        
        return $this->render('admin/chocolaterie/index.html.twig', [
            'chocolateries' => $chocPerPage,
            'pages' => $page,
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/new', name: 'app_chocolaterie_new', methods: ['GET', 'POST'])]
    public function new(Request $request,FileUploader $fileUploader, EntityManagerInterface $em, ChocolaterieRepository $chocolaterieRepository): Response
    {
        $chocolaterie = new Chocolaterie();
        $form = $this->createForm(ChocolaterieType::class, $chocolaterie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chocolaterieRepository->add($chocolaterie, true);

        /** @var UploadedFile $imageFile */

            //Récupère la donnée du champs ImageBandeau du usertype et le stoke
            $imageFile = $form->get('photo')->getData();
      
            //Cette condition est nécessaire car le champ 'ImageBandeau' n'est pas obligatoire
            //Donc le fichier doit être traité uniquement lorsqu'il est téléchargé et non vide 

               if (!empty($imageFile)) {

                   $imageFileName = $fileUploader->upload($imageFile);
                   //Met à jour la propriété 'setImageBandeau' pour stocker le nom du fichier et sa concaténation (chemin du fichier) 
                   $chocolaterie->setPhoto('../data/'. $imageFileName);
               }

            // Persiste la variable $user ou tout autre travail
            $em->persist($chocolaterie);

            // Hydrate la bdd
            $em->flush();    

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
    public function edit(Request $request, FileUploader $fileUploader, EntityManagerInterface $em, Chocolaterie $chocolaterie, ChocolaterieRepository $chocolaterieRepository): Response
    {
        $form = $this->createForm(ChocolaterieType::class, $chocolaterie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $chocolaterieRepository->add($chocolaterie, true);

             /** @var UploadedFile $imageFile */

            //Récupère la donnée du champs ImageBandeau du usertype et le stoke
            $imageFile = $form->get('photo')->getData();
      
            //Cette condition est nécessaire car le champ 'ImageBandeau' n'est pas obligatoire
            //Donc le fichier doit être traité uniquement lorsqu'il est téléchargé et non vide 

               if (!empty($imageFile)) {

                   $imageFileName = $fileUploader->upload($imageFile);
                   //Met à jour la propriété 'setImageBandeau' pour stocker le nom du fichier et sa concaténation (chemin du fichier) 
                   $chocolaterie->setPhoto('../data/'. $imageFileName);
               }

            // Persiste la variable $user ou tout autre travail
            $em->persist($chocolaterie);

            // Hydrate la bdd
            $em->flush();    

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
