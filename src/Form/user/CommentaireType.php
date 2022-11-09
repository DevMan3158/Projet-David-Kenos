<?php

namespace App\Form\user;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\Commentaire;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommentaireType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {



    

        $builder
       

            ->add('contenu', TextareaType::class, [
                'required' => true,
                'label' => "Commentaire ",
                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un commentaire'
                    ]),

                ]
            ])
            
                ;
            }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaire::class,
        ]);
    }
}