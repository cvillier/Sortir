<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\File;

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
            ->add('campus')
//            ->add('photo', FileType::class, [
//                'label' => 'Ma photo : ',
//                'mapped' => false,
//                'required' => false,
//                'constraints' => [
//                    new File([
//                        'maxSize' => '10000k',
//                        'mimeTypes' => [
//                            'image/jpeg',
//                            'image/png',
//                            'image/gif'
//                        ],
//                        'mimeTypesMessage' => 'Please upload a valid picture',
//                    ])
//                ],
//            ])
            ->add('button', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
