<?php

namespace App\Form;

use App\Entity\Fault;
use App\Entity\Intervention;
use App\Entity\Stock;
use App\Entity\Utilisateur;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $intervention = $builder->getData();
        $allUsers = $options['users'] ?? [];

        $chauffagistes = array_filter($allUsers, fn(Utilisateur $user) =>
        in_array('ROLE_CHAUFFAGISTE', $user->getRoles(), true)
        );

        $currentUser = $intervention->getUser();
        if ($currentUser && !in_array($currentUser, $chauffagistes, true)) {
            $chauffagistes[] = $currentUser;
        }

        $builder
            ->add('Wording', TextType::class)
            ->add('Timestamp', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('Description', TextType::class)
            ->add('Address', TextType::class)
            ->add('Status', TextType::class)
            ->add('user', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => fn(Utilisateur $user) => $user->getFirstName() . ' ' . $user->getLastName(),
                'choices' => $chauffagistes,
                'label' => 'Chauffagiste assigné',
                'placeholder' => 'Sélectionnez un chauffagiste',
                'required' => true,
            ])
            ->add('fault', EntityType::class, [
                'class' => Fault::class,
                'choice_label' => 'Wording',
            ])
            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'choice_label' => 'LicensePlate',
                'required' => false,
            ])
            ->add('stocks', EntityType::class, [
                'class' => Stock::class,
                'choice_label' => 'Wording',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
            'users' => [],
        ]);
    }
}
