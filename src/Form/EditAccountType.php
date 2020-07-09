<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo')
//            ->add('roles')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Organisateur' => 'ROLE_ORGANISATEUR',
                    'Participant' => 'ROLE_PARTICIPANT',
                ],
                'expanded'  => false, // liste déroulante
                'multiple'  => true, // choix multiple
            ])
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')
            ->add('actif')
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo : '
            ])

//            ->add('roles')

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe : '
            ])

            ->add('nom', TextType::class, [
                'label' => 'Nom : '
            ])

            ->add('prenom', TextType::class, [
                'label' => 'Prénom : '
            ])

            ->add('telephone', IntegerType::class, [
                'label' => 'Téléphone : '
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])

            ->add('campus')

//            ->add('actif')

            ->add('photo', FileType::class, [
                'label' => 'Ma photo : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
