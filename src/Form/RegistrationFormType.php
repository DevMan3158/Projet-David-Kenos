<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Chocolaterie;
use Symfony\Component\Form\AbstractType;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options ): void
    {
        $builder
   

            ->add('nom', TextType::class, [
                'required' => true,
                'label' => "Nom :",
                'attr' => ['class' => 'input_Reg_Form'],
                

                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un nom'
                    ]),
                ]
                
                ])

            ->add('prenom', TextType::class, [
                'required' => true,
                'label' => "Prénom :",
                'attr' => ['class' => 'input_Reg_Form'],
                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un prénom'
                    ]),

                ]
                
            ])

     
            ->add('poste', TextType::class, [
                'required' => true,
                'label' => "Poste :",
                'attr' => ['class' => 'input_Reg_Form'],

                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un poste'
                    ]),

                ]
            ])

            // appel l'entity Chocolaterie afin de pouvoir afficher enregistrement de celle-ci
            ->add('chocolaterie', EntityType::class, [
                'required' => true,
                'class' => Chocolaterie::class,
                'query_builder' => function (ChocolaterieRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
                'attr' => ['class' => 'input_Reg_Form'],
                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir une chocolaterie'
                    ]),

                ]
            ])
           
            ->add('email', EmailType::class, [
                   'required' => true,
                   'label' => "Email :",
                   'attr' => ['class' => 'input_Reg_Form'],

                   'constraints' =>
                
                   [
                       new NotBlank([
                          'message' => 'Veuillez saisir un nom'
                       ]),
   
                   ]
               ])

            // On rentre le mot de passe et on repète avec RepeatedType pour confirmation

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'first_options' => [
                    'label' => "Mot de passe :",

                    'attr' => ['autocomplete' => 'Nouveau Mot de Passe '],
                    'attr' => ['class' => 'input_Reg_Form'],

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
                    'required' => true,
                    'label' => "Répeter le Mot de Passe :",
                    'attr' => ['autocomplete' => 'Nouveau Mot de Passe'],
                    'attr' => ['class' => 'input_Reg_Form'],
                    
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
            
            
                ->add('AgreeTerms', CheckboxType::class, [   
                'mapped' => false,
                'label' => "Accepter les termes et conditions",
                'attr' => ['class' => 'inputteste'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter les conditions.',
                    ]),
                ],
            ]);;


        
        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
