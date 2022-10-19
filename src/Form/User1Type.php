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
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('facebook', UrlType::class,['required' => false])
            
            ->add('instagram', UrlType::class,['required' => false])
            
            ->add('twitter', UrlType::class,['required' => false])
            
            ->add('linkedin', UrlType::class,['required' => false])
            
            ->add('lien', UrlType::class,['required' => false])
            
            ->add('description', TextType::class,['required' => false])
            
            ->add('email', EmailType::class)

            ->add('ImageBandeau',FileType::class, 
            [
                'label' => 'Photo du bandeau',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes

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

            ->add('ImageProfil',FileType::class, 
            [
                "mapped"=>false,

                'data_class'=>null,

                'label'=> 'Photo de profil',
                
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

            ->add('nom', TextType::class, [
            
            'constraints' =>
                
            [
                new NotBlank([
                   'message' => 'Veuillez saisir un nom'
                ]),
            ]
            
            ])
            
            ->add('prenom', TextType::class, [
            
                'constraints' =>
                    
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un nom'
                    ]),
                ]
                
                ])
            ->add('poste', TextType::class, [
            
                'constraints' =>
                    
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un nom'
                    ]),
                ]
                
                ])
             ->add('chocolaterie', EntityType::class, [
                'required' => true,
                'class' => Chocolaterie::class,
                'query_builder' => function (ChocolaterieRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom'
            ]);
            
             /* ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => false,
                'first_options' => [
                    'label' => "Mot de passe :",

                    'attr' => ['autocomplete' => 'Nouveau Mot de Passe '],
                    'constraints' => [

                        new NotBlank([
                            'message' => 'Répeter le Mot de Passe ',
                        ]),
                        
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    
                ],

                'second_options' => [
                    'required' => false,
                    'label' => "Répeter le Mot de Passe :",
                    'attr' => ['autocomplete' => 'Nouveau Mot de Passe'],          
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ]);*/

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

