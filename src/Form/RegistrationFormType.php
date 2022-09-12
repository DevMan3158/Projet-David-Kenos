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
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext',
                ]
            ])


            ->add('prenom', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext',
                ]
            ])

     
            ->add('poste', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control-plaintext',
                ]
            ])

            // appel l'entity Chocolaterie afin de pouvoir afficher enregistrement de celle-ci
            ->add('chocolaterie', EntityType::class, [
                'class' => Chocolaterie::class,
                'query_builder' => function (ChocolaterieRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
            ])
           
            ->add('email', EmailType::class, [
                   'label' => false,
                   'attr' => [
                       'class' => 'form-control-plaintext',
                   ]
               ])

            // On rentre le mot de passe et on repète avec RepeatedType pour confirmation

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
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
                    'attr' => ['autocomplete' => 'Nouveau Mot de Passe'],
                    
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
            
            
                        ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
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
