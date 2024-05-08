<?php
// src/Form/CategoriesType.php
// src/Form/CategoriesType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoryName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Category name cannot be blank.']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Category name must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Category name cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('subfield', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Subfield cannot be blank.']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Subfield must be at least {{ limit }} characters long.',
                        'maxMessage' => 'Subfield cannot be longer than {{ limit }} characters.',
                    ]),
                ],
            ])
            ->add('typeOfFunding', ChoiceType::class, [
                'choices' => [
                    'Crowdfunding' => 'crowdfunding',
                    'Self Funding' => 'selffunding',
                    'Venture Capital' => 'venturecapital',
                ],
            ])
            ->add('profitabilityIndex', ChoiceType::class, [
                'choices' => [
                    'High' => 'high',
                    'Medium' => 'medium',
                    'Low' => 'low',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // Remove 'data_class' option
    }
}
