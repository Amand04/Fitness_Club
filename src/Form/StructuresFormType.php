<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\Structures;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructuresFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('store_name', TextType::class, ['label' => 'Nom de la structure'])
            ->add('active')
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('adress', TextType::class, ['label' => 'Adresse'])
            ->add('country', TextType::class, ['label' => 'Ville'])
            ->add('phone', TextType::class, ['label' => 'Numéro de téléphone'])
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
                        return $partners->getId() . " (" . $partners->getName() . ")";
                    },
                    'label' => 'Partenaire affilié',
                    'multiple' => false, 'expanded' => false, 'mapped' => true,

                ]
            )
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => function ($user) {
                        return "Identifiant n° " .  $user->getId() . " (" . $user->getEmail() . ")";
                    },
                    'label' => 'Compte utilisateur de la structure',
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
