<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


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
                ->add('telephone', TextType::class, [
                    'label' => 'Téléphone : '
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Email'
                ])
                //->add('button', SubmitType::class)

                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'first_options' => ['label' => 'Mot de passe : '],
                    'second_options' => ['label' => 'Confirmation : '],
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

                ->add('campus')

              //->add('actif')

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
                ])

                ->add('photo', EditPhotoType::class, [
                    'label' => 'Ma photo'
                ])
            ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
