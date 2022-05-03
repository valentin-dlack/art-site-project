<?php

namespace App\Form;

use App\Entity\Commission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', ChoiceType::class, [
                'choices' => [
                    'Headshot - 30$' => 'Headshot',
                    'Halfbody - 50$' => 'Halfbody',
                    'Fullbody - 100$' => 'Fullbody',
                    'Full Illustration (2 fullbody + bg) - 250$' => 'Full Illustration_2',
                    'Full Illustration (1 fullbody + bg) - 200$' => 'Full Illustration_1',
                    'Refsheet - 130$' => 'Refsheet',
                    'Refsheet + Clothing - 190$' => 'Refsheet + Clothing',
                ],
                "attr" => [
                    "class" => "px-4 py-2 mb-5 rounded border border-grey-light focus:outline-none focus:border-indigo-500 text-base leading-6 font-medium text-gray-900",
                ],
                'label' => false,
            ])
            ->add('refsheet', TextType::class, [
                "attr" => [
                    "class" => "px-4 py-2 rounded border border-grey-light focus:outline-none focus:border-indigo-500 text-base leading-6 font-medium text-gray-900",
                    "placeholder" => "Refsheet link"
                ],
                "label" => false
            ])
            ->add('details' , TextareaType::class, [
                "attr" => [
                    "class" => "px-4 py-2 my-5 rounded border border-grey-light w-full h-64 focus:outline-none focus:border-indigo-500 text-base leading-6 font-medium text-gray-900",
                    "style" => "resize: none;",
                    "placeholder" => "Details of your commission",
                ],
                "label" => false,
            ])  
            ->add('submit', SubmitType::class, [
                "attr" => [
                    "class" => "px-4 py-2 bg-blue-400 text-white rounded w-full text-center"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commission::class,
        ]);
    }
}
