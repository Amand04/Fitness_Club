<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\Structures;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('partners', EntityType::class, [
                'class' => Partners::class,
                'choice_label' => 'id',
                'label' => 'ID du partenaire',
            ])
            ->add('store_name')

            ->add('director_name')
            ->add('email')
            ->add('adress')
            ->add('country')
            ->add('description')
            ->add('phone')
            ->add('image')
            ->add('is_active')
            ->add('permissions', EntityType::class, [
                'class' => Permissions::class, 'choice_label' => function ($permissions) {
                    return $permissions->getId() . ' ' . $permissions->getName();
                },
                'disabled' => true, 'multiple' => true,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Structures::class,
        ]);
    }
}
