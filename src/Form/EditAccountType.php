<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo : '
            ])

            ->add('prenom', TextType::class, [
                'label' => 'Prénom : '
            ])

            ->add('nom', TextType::class, [
                'label' => 'Nom : '
            ])

            ->add('telephone', IntegerType::class, [
                'label' => 'Téléphone : '
            ])

            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])

            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe : '
            ])

//            ajouter confirmation password

            ->add('campus')

            ->add('photo', FileType::class, [
                'label' => 'Ma photo : '
            ])

//            ->add('actif')

            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Organisateur' => 'ROLE_ORGANISATEUR',
                    'Participant' => 'ROLE_PARTICIPANT',
                ],
                'expanded'  => false, // liste déroulante
                'multiple'  => true, // choix multiple
                'label' => 'Le rôle de cet utilisateur : '
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
