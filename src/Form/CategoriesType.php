<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categoryName')
            ->add('subfield')
            ->add('typeOfFunding', ChoiceType::class, [
                'choices' => [
                    'Crowdfunding' => 'crowdfunding', // 'Label' => 'value'
                    'Self Funding' => 'selffunding',
                    'Venture Capital' => 'venturecapital',
                ],
            ])
            ->add('profitabilityIndex', ChoiceType::class, [
                'choices' => [
                    'High' => 'high', // 'Label' => 'value'
                    'Medium' => 'medium',
                    'Low' => 'low',
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
