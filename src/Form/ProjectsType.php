<?php

namespace App\Form;

use App\Entity\Projects;
use App\Entity\Categories; // Assuming you have a Category entity
use Symfony\Bridge\Doctrine\Form\Type\EntityType; // For category selection
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType; // For predefined choices
use Symfony\Component\Form\Extension\Core\Type\FileType; // For image upload
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('image', FileType::class, [
            'label' => 'Project Image',
            'mapped' => false,
            'required' => false,
            'constraints' => [
                new Assert\File([
                    'maxSize' => '5M',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                        'image/gif',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, GIF)',
                ]),
            ],
        ])
        
        ->add('name', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('description', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 1000,
                ]),
            ],
        ])
        ->add('targetAudience', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('demandInMarket', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('developmentTimeline', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('budgetFundingRequirements', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('riskAnalysis', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 1000,
                ]),
            ],
        ])
        ->add('marketStrategy', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 1000,
                ]),
            ],
        ])
        ->add('exitStrategy', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('teamBackground', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 1000,
                ]),
            ],
        ])
        ->add('tags', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 255,
                ]),
            ],
        ])
        ->add('uniqueSellingPoints', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length([
                    'max' => 1000,
                ]),
            ],
        ])
        ->add('dailyPriceOfAssets', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type([
                    'type' => 'numeric',
                    'message' => 'The value {{ value }} is not a valid number.',
                ]),
            ],
        ])
        ->add('investorsEquity', null, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Type([
                    'type' => 'numeric',
                    'message' => 'The value {{ value }} is not a valid number.',
                ]),
            ],
        ])
        ->add('category', EntityType::class, [
            'class' => Categories::class,
            'choice_label' => 'name',
            'placeholder' => 'Choose a category',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
}

}