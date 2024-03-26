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

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Assuming 'image' is a property meant to handle file uploads
            ->add('image', FileType::class, [
                'label' => 'Project Image',
                'mapped' => false,
                'required' => false,
            ])
            
            ->add('name')
            ->add('description')
            ->add('targetAudience')
            ->add('demandInMarket')
            ->add('developmentTimeline')
            ->add('budgetFundingRequirements')
            ->add('riskAnalysis')
            ->add('marketStrategy')
            ->add('exitStrategy')
            ->add('teamBackground')
            ->add('tags')
            ->add('uniqueSellingPoints')
            ->add('dailyPriceOfAssets')
            ->add('investorsEquity')
            ->add('category', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a category',
            ])
            // If you have statuses to choose from, you could add a field like this:
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
