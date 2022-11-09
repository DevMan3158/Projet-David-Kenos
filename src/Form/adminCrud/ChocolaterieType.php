<?php

namespace App\Form\adminCrud;

use App\Entity\Chocolaterie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ChocolaterieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('lieu')
            ->add('photo',FileType::class, 
            [
              
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'maxSizeMessage' => "Taille du fichier supérieur à 5MB.",
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                            'image/tiff',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Fichier accepté : png, jpeg, gif, tiff',
                    ])
               ],        

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Chocolaterie::class,
        ]);
    }
}
