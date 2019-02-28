<?php

namespace App\Form;

use App\Entity\Client;
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

class RegistrationFormType extends AbstractType
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
            ->add('companyName', TextType::class, [
                'label' => 'Название компании',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter your company\'s name or "Myself" if you represent none',
                    ]),
                    new Length([
                        'min' => 1,
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('inn', TextType::class, [
                'label' => 'ИНН',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 16,
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Адрес',
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 1,
                        'max' => 1000,
                    ]),
                ],
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
            'data_class' => Client::class,
            'empty_data' => function (FormInterface $form) {
                return new Client(
                    $form->get('companyName')->getData(),
                    $form->get('inn')->getData(),
                    $form->get('address')->getData(),
                    $form->get('email')->getData(),
                    $form->get('tel')->getData()
                );
            },
        ]);
    }
}
