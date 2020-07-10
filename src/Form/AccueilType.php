<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccueilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('villes', ChoiceType::class, [
                'choices' => [
                    'Chartres-de-Bretagne' => 'Chartres-de-Bretagne',
                    'Saint-Herblain' => 'Saint-Herblain',
                    'Niort' => 'Niort',
                    'Quimper' => 'Quimper',
                ],
                'expanded'  => false, // liste déroulante
                'multiple'  => false, // choix multiple
                'label' => 'Campus : ',
                'label_attr' => ['class' => 'col-sm-5 col-form-label'],
                'attr' => ['class' => 'form-control col-sm-7'],
            ])
            ->add('organisateur', CheckboxType::class, [
                'label' => 'Sorties dont je suis l\'organisateur/trice',
                'required' => false,
            ])
            ->add('inscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])
            ->add('nonInscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])
            ->add('sortiesPassees', CheckboxType::class, [
                'label' => 'Sorties passées',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
