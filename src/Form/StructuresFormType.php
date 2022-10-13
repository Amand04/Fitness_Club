<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\Structures;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructuresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('store_name')
            ->add('active')
            ->add('email')
            ->add('adress')
            ->add('country')
            ->add('phone')
            ->add('newsletter')
            ->add('promote')
            ->add('planning')
            ->add('statistics')
            ->add('products')
            ->add('digicode')
            ->add(
                'partners',
                EntityType::class,
                [
                    'class' => Partners::class,
                    'choice_label' => function ($partners) {
                        return " Identifiant n° " . $partners->getId();
                    },
                    'label' => 'Partner',
                    'multiple' => false, 'expanded' => false, 'mapped' => true,

                ]
            )
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => function ($user) {
                        return " Identifiant n° " .  $user->getId();
                    },
                    'label' => 'Compte utilisateur',
                    'multiple' => false, 'expanded' => false, 'mapped' => true,

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structures::class,
        ]);
    }
}
