<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\Permissions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PermissionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'perms',
                ChoiceType::class,
                [
                    'label' => 'Permission à créer',
                    'choices' => [
                        'Newsletter' => 'Newsletter',
                        'Promote' =>  'Promote',
                        'Planning' => 'Planning',
                        'Statistics' => 'Statistics',
                        'Products' => 'Products',
                        'Digicode' => 'Digicode'

                    ]
                ]
            )
            ->add('active')
            ->add(
                'partners',
                EntityType::class,
                [
                    'class' => Partners::class,
                    'choice_label' => function ($partner) {
                        return $partner->getId() . " (" . $partner->getName() . ")";
                    },
                    'label' => 'Partenaire à associer',
                    'multiple' => false, 'expanded' => false, 'mapped' => true,

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Permissions::class,
        ]);
    }
}
