<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Chocolaterie;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ImageBandeau',FileType::class, 
            [
                "mapped"=>false,
                'data_class'=>null,
                'label'=> 'Image de bandeau',
                 'required' => false

                 ])

            ->add('ImageProfil',FileType::class, 
            [
                "mapped"=>false,
                'data_class'=>null,
                'label'=> 'Image de profil', 
                'required' => false
                
                ])

            ->add('email')
            ->add('nom')
            ->add('prenom')
            ->add('poste')
             ->add('chocolaterie', EntityType::class, [
                'required' => true,
                'class' => Chocolaterie::class,
                'query_builder' => function (ChocolaterieRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom'
            ])
            ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}


/*$ImageFile = $form->get('image')->getData();

// this condition is needed because the 'brochure' field is not required
// so the PDF file must be processed only when a file is uploaded
if ($ImageFile) {
    $ImageFileNom = $fileUploader->upload($ImageFile);
    $property->setimage($ImageFileNom);

    // Move the file to the directory where brochures are stored
 /*   try {
        $brochureFile->move(
            $this->getParameter('image_prof'),
            $newFilename
        );
    } catch (FileException $e) {
        // ... handle exception if something happens during file upload
    }
    // updates the 'brochureFilename' property to store the PDF file name
    // instead of its contents
    $property->setImage($newFilename);
}



$this->em->flush();
$this->addFlash('success', 'Profils modifiés');*/