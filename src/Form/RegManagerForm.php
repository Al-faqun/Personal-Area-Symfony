<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Manager;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegManagerForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'mapped' => false,
                'label' => 'Имя пользователя',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 180
                    ])
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Пароль',
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
            ->add('name', TextType::class, [
                'label' => 'Имя',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 255
                    ])
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Фамилия',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 255
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 256,
                    ]),
                ],
            ])
            ->add('tel', TelType::class, [
                'label' => 'Телефон',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 100,
                    ]),
                ],
            ])
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Manager::class,
        ]);
    }
}
