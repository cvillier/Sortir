<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        if (in_array('ROLE_ADMIN', $options['role'])) {
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
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone : '
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('button', SubmitType::class)

//            ->add('password', PasswordType::class, [
//                'label' => 'Mot de passe : '
//            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

//            ajouter confirmation password

            ->add('campus')

//            ->add('photoFile', FileType::class, [
//                'label' => 'Ma photo : '
//            ])

//            ->add('actif')

            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'User' => 'ROLE_USER',
                    'Organisateur' => 'ROLE_ORGANISATEUR',
                    'Participant' => 'ROLE_PARTICIPANT',
                ],
                'expanded' => false, // liste déroulante
                'multiple' => true, // choix multiple
                'label' => 'Le rôle de cet utilisateur : '
            ]);
//        } else {

    }

//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
