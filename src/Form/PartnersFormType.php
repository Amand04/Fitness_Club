<?php

namespace App\Form;

use App\Entity\Partners;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['label' => 'Email'])
            ->add('name', TextType::class, ['label' => 'Nom du partenaire'])
            ->add('active')
            ->add('short_description', TextType::class, ['label' => 'Extrait de la description'])
            ->add('long_description', TextType::class, ['label' => 'Description'])
            ->add('url', TextType::class, ['label' => 'URL'])
            ->add('technical_contact', TextType::class, ['label' => 'Contact technique'])
            ->add('commercial_contact', TextType::class, ['label' => 'Contact commercial'])
            ->add(
                'user',
                EntityType::class,
                [
                    'class' => User::class,
                    'choice_label' => function ($user) {
                        return $user->getId();
                    },
                    'label' => 'Compte utilisateur du partenaire ',
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
