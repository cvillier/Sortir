<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                    'label' => 'Pseudo : ',
                    'label_attr' => [
                        'class' => 'col-sm-12 col-lg-4 col-form-label'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('prenom', TextType::class, [
                    'label' => 'Prénom : ',
                    'label_attr' => [
                        'class' => 'col-sm-12 col-lg-4 col-form-label'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('nom', TextType::class, [
                    'label' => 'Nom : ',
                    'label_attr' => [
                        'class' => 'col-sm-12 col-lg-4 col-form-label'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('telephone', TextType::class, [
                    'label' => 'Téléphone : ',
                    'label_attr' => [
                        'class' => 'col-sm-12 col-lg-4 col-form-label'
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('email', EmailType::class, [
                    'label' => 'Email : ',
                    'label_attr' => [
                        'class' => 'col-sm-12 col-lg-4 col-form-label'
                    ],
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ])

                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'constraints' => array(
                        new NotBlank(),
                        new Length(array('min' => 6)),
                    ),
                    'first_options'  => [
                        'label' => 'Mot de passe : ',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                        'label_attr' => [
                        'class' => 'col-sm-12 col-lg-4 col-form-label'
                        ],
                    ],
                    'second_options'  => [
                        'label' => 'Confirmation : ',
                        'attr' => [
                            'class' => 'form-control',
                        ],
                        'label_attr' => [
                            'class' => 'col-sm-12 col-lg-4 col-form-label'
                        ],
                    ],
                ])

            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'label' => 'Campus : ',
                'label_attr' => [
                    'class' => 'col-sm-12 col-lg-4 col-form-label'
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
//
////            ->add('photoFile', FileType::class, [
////                'label' => 'Ma photo : '
////            ])
//
////            ->add('actif')
///
                ->add('roles', ChoiceType::class, [
                    'label' => 'Roles : ',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'choices' => [
                        'Admin' => 'ROLE_ADMIN',
                        'User' => 'ROLE_USER',
                        'Organisateur' => 'ROLE_ORGANISATEUR',
                        'Participant' => 'ROLE_PARTICIPANT',
                    ],
                    'multiple' => true,
            ]);
    }

//    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
