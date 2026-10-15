<?php

namespace App\Form;

use App\Entity\Skill;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class)
            ->add('FirstName', TextType::class)
            ->add('LastName', TextType::class)
            ->add('BirthDate', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('Phone', TextType::class)
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Secretaire' => 'ROLE_SECRETAIRE',
                    'Chauffagiste' => 'ROLE_CHAUFFAGISTE',
                    'Admin' => 'ROLE_ADMIN', // Ajouté si besoin de créer des admins
                ],
                'multiple' => true,
                'expanded' => true, // pour avoir des cases à cocher
            ])
            ->add('skills', EntityType::class, [
                'class' => Skill::class,
                'choice_label' => 'Wording',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'required' => $options['password_required'],
                'label' => 'Mot de passe',
                'empty_data' => '',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'password_required' => true,
        ]);

        $resolver->setAllowedTypes('password_required', 'bool');
    }
}
