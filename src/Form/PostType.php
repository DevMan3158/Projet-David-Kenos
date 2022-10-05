<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\CatPost;
use App\Repository\CatPostRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextType::class, [
                'required' => true,
                'label' => "Contenu",

                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un Contenu'
                    ]),

                ]
            ])
            ->add('image_post')
            ->add('image_post_alt')
            ->add('cat_post', EntityType::class, [
                'required' => true,
                'class' => CatPost::class,
                'query_builder' => function (CatPostRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
                'label' => 'Catégories',
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
