<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\Permissions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('store_name')
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('adress')
            ->add('country')
            ->add('description')
            ->add('phone')
            ->add('image')
            ->add('is_active')
            ->add(
                'permissions',
                EntityType::class,
                [
                    'class' => Permissions::class,
                    'choice_label' => function ($permissions) {
                        return $permissions->getName();
                    },
                    'multiple' => true, 'expanded' => true

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partners::class,
        ]);
    }
}
