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
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
                

            ])

            ->add('ImageProfil',FileType::class, 
            [
                "mapped"=>false,
                'data_class'=>null,
                'label'=> 'Photo de profil', 
                'required' => false
                
                ])/**/

          
            ->add('facebook')
            ->add('instagram')
            ->add('twitter')
            ->add('linkedin')
            ->add('lien')
            ->add('description')
            ->add('email')
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
                    'attr' => ['class' => 'input_Reg_Form'],
                    
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

