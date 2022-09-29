<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\CatPost;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\CatPostRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu')
            ->add('image_post')
            ->add('image_post_alt')

            ->add('cat_post', EntityType::class, [
                'required' => true,
                'class' => CatPost::class,
                'query_builder' => function (CatPostRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom'
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
