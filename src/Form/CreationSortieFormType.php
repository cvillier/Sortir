<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la sortie : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('datedebut', DateTimeType::class, [
                'label' => 'Date et heure de la sortie : ',
                "widget" => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => ""
                ]
            ])
            ->add('datecloture', DateTimeType::class, [
                'label' => 'Date limite d inscription : ',
                "widget" => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => ""
                ]
            ])
            ->add('nbinscriptionsmax', IntegerType::class, [
                'label' => 'Nombre de places : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée : ',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => '90 minutes'
                ]
            ])
            ->add('descriptioninfos', TextType::class, [
                'label' => 'Description et infos : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add("nom_ville", EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'nom_ville',
                'mapped' => false,
                'label' => 'Ville : ',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add("noLieu", EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom_lieu',
                'label' => 'Lieu',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
