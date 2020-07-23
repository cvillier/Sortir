<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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

                ->add('plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    // instead of being set onto the object directly,
                    // this is read and encoded in the controller
                    'first_options' => ['label' => 'Mot de passe : ',
                        'label_attr' => ['class' => 'col-sm-12 col-lg-4 col-form-label'],
                        'attr' => ['class' => 'form-control']
                    ],
                    'second_options' => ['label' => 'Confirmation : ',
                        'label_attr' => ['class' => 'col-sm-12 col-lg-4 col-form-label'],
                        'attr' => ['class' => 'form-control'],
                    ],
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

              //->add('actif')

              ->add('roles', ChoiceType::class, [
                  'label' => 'Roles : ',
                  'attr' => [
                      'class' => 'form-control'
                  ],
                  'label_attr' => [
                      'class' => 'col-sm-12 col-lg-4 col-form-label'
                  ],
                  'choices' => [
                      'Admin' => 'ROLE_ADMIN',
                      'User' => 'ROLE_USER',
                      'Organisateur' => 'ROLE_ORGANISATEUR',
                      'Participant' => 'ROLE_PARTICIPANT',
                  ],
                  'multiple' => true,
              ])

            ->add('photoFile', FileType::class, [
                'label_attr' => [
                    'class' => 'col-sm-12 col-lg-4 col-form-label'
                ],
                'attr' => [ 'class' => 'form-control-file'],
                'mapped' => false,
                'required' => false,
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
