<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\CatPost;
use App\Repository\CatPostRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Contenu du post',
                    'style' => 'width: 100%; height: 150px',
                    'wrap' => 'on',
                ),
                'constraints' =>
                
                [
                    new NotBlank([
                       'message' => 'Veuillez saisir un Contenu'
                    ]),

                ]
            ])
            ->add('image_post', FileType::class, [


                'label' => false,
                

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez choisir un fichier de type JPEG, JPG ou PNG de 1024k maximum.',
                    ])
                ],
            ])
            ->add('image_post_alt', null, array(
                'label' => false,
                'attr' => array(
                'placeholder' => 'Description de l\'image')))

            ->add('cat_post', EntityType::class, [
                'required' => true,
                'class' => CatPost::class,
                'query_builder' => function (CatPostRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom',
                'label' => false,
                ])
            ->add('Publier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
