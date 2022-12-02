<?php

namespace App\Form;

use App\Entity\Formateur;
use App\Entity\SessionFormation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SessionFormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intitule', TextType::class, ['label' => 'Nom de la session'])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text', 'label' => "Date d'entrées"
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text', 'label' => "Date de sorties"
            ])
            ->add('placeTotal', IntegerType::class, ['label' => 'Nombre de places'])
            ->add('formateur', EntityType::class, [
                'class' => Formateur::class,
                'choice_label' => 'Identite'
            ])
            ->add('submit', SubmitType::class, ['label' => 'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SessionFormation::class,
        ]);
    }
}