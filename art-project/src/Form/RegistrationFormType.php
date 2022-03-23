<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'border border-grey-light w-full px-2 py-3 rounded shadow-sm mb-4',
                    'placeholder' => 'Email'
                ]
            ], array('label' => false))
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'border border-grey-light w-full px-2 py-3 rounded shadow-sm mb-4',
                    'placeholder' => 'Full name'
                ]
            ], array('label' => false))
            ->add('user_state', IntegerType::class, [
                'attr' => [
                    'value' => '0',
                ]
            ])
            ->add('coms_state', IntegerType::class, [
                'attr' => [
                    'value' => '0',
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Please agree with our terms and conditions !',
                    ]),
                ],
                'attr' => [
                    'class' => 'checked:bg-green-500',
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'border border-grey-light w-full py-3 rounded shadow-sm mb-4',
                    'placeholder' => 'Password'
                ],
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
                'invalid_message' => 'The password fields must match.',
                'options' => ['attr' => [
                    'class' => 'border border-grey-light w-full px-2 py-3 rounded shadow-sm mb-4',
                    'placeholder' => 'Password confirmation'
                    ]],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],
            ], array('label' => false));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
