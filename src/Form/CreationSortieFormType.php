<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, [
                'label'  => 'Nom de la sortie : '
            ])

            ->add('datedebut', DateTimeType::class, [
                'label'  => 'Date et heure de la sortie : ',
                "widget" => 'single_text',
                "data" => new \DateTime(),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])

            ->add('datecloture')
            ->add('nbinscriptionsmax')
            ->add('duree')
            ->add('descriptioninfos')
            ->add("campus", EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom_campus',

            ])
            ->add("nom_ville", EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'nom_ville',
                'mapped' => false
            ])
            ->add("noLieu", EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom_lieu',

            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
