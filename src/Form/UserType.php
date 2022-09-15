<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Chocolaterie;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\ChocolaterieRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('chocolaterie', EntityType::class, [
                'required' => true,
                'class' => Chocolaterie::class,
                'query_builder' => function (ChocolaterieRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'choice_label' => 'nom'
            ])
            ->add('roles')          
            ->add('nom')
            ->add('prenom')
            ->add('poste')
            ->add('description')
            ->add('linkedin')
            ->add('facebook')
            ->add('instagram')
            ->add('twitter')
            ->add('lien')
            ->add('image_profil')
            ->add('image_profil_alt')
            ->add('image_bandeau')
            ->add('image_bandeau_alt')
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                    fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0]: null,
                    fn ($rolesAsString) => [$rolesAsString]
            ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
