<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $targetDirectory;
    private $slugger;

    public function __construct($targetDirectory, SluggerInterface $slugger)
    {
        $this->targetDirectory = $targetDirectory;
        $this->slugger = $slugger;
    }

    public function upload(UploadedFile $file)
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        //Ceci est nécessaire pour inclure en toute sécurité le nom du fichier dans l'URL
        $safeFilename = $this->slugger->slug($originalFilename);

        //'Enregistrement dans la bdd et donne un  id unique au fichier avec son extension  
        $fileName = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();


        //Définit TargetDirectory dans le fichier service.yaml(data)   
        //Déplace le fichier dans le répertoire où sont stockées les fichiers
        try {
            $file->move($this->getTargetDirectory(), $fileName);
        
        //Gérer l'exception si quelque chose se passe pendant le téléchargement du fichier
        } catch (FileException $e) {

        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}