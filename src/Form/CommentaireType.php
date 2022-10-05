<?php

namespace App\Form;

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

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          
        ->add('user', EntityType::class, [
            'required' => true,
            'class' => User::class,
            'query_builder' => function (UserRepository $er) {
                return $er->createQueryBuilder('c');
            },
            'choice_label' => 'nom',
            'label' => 'Utlisateur',
            ])
            ->add('contenu', TextType::class, [
                'required' => true,
                'label' => "Commentaire ",
                'attr' => ['class' => 'input_Reg_Form'],

                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un poste'
                    ]),

                ]
            ])




            
            ->add('post', EntityType::class, [
            'required' => true,
            'class' => Post::class,
            'query_builder' => function (PostRepository $er) {
                return $er->createQueryBuilder('c');
            },
            'choice_label' => 'contenu',
            'label' => 'Post',
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