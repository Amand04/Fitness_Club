<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\Permissions;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('email')
            ->add('name')
            ->add('active')
            ->add('short_description')
            ->add('long_description')
            ->add('logo')
            ->add('url')
            ->add('technical_contact')
            ->add('commercial_contact')
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => function ($user) {
                        return $user->getId();
                    },
                    'label' => 'user_id',
                    'multiple' => false, 'expanded' => false, 'mapped' => true,

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
