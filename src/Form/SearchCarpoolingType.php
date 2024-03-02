<?php

namespace App\Form;

// src/Form/SearchCarpoolingType.php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchCarpoolingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('departure', TextType::class, [
                'label' => 'Departure Place',
                'required' => true,
            ])
            ->add('destination', TextType::class, [
                'label' => 'Destination',
                'required' => true,
            ])
            ->add('departureDate', DateType::class, [
                'label' => 'Departure Date',
                'required' => true,
                'widget' => 'single_text',
            ])
            ->add('time', TimeType::class, [
                'label' => 'When',
                'required' => true,
            ])
            
            ->add('search', SubmitType::class, ['label' => 'Search'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // configure options
        ]);
    }
}


   