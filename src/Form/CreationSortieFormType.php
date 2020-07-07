<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieux;
use App\Entity\Sorties;
use App\Entity\Villes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreationSortieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('datedebut')
            ->add('datecloture')
            ->add('nbinscriptionsmax')
            ->add('duree')
            ->add('descriptioninfos')
            ->add("noCampus", EntityType::class, [
                'class' => Campus::class,
                'choice_label' => 'nom_campus',
                'mapped' => false
            ])
            ->add("nom_ville", EntityType::class, [
                'class' => Villes::class,
                'choice_label' => 'nom_ville',
                'mapped' => false
            ])
            ->add("nom_lieu", EntityType::class, [
                'class' => Lieux::class,
                'choice_label' => 'nom_lieu',
                'mapped' => false,
            ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }
}
