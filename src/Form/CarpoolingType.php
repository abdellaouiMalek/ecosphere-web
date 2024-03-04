<?php

namespace App\Form;

use App\Entity\Carpooling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CarpoolingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('departure' , TextType::class , [
                'constraints' => [
                    new NotBlank(['message' => 'You have to mention the departure place',
                ]),
                ] 
            ])
           
           
           
          /*  ->add('departureDate', DateType::class ,  [
                'constraints' => [
                    new NotBlank(['message' => 'You have to mention the date',
                ]),
                ] 
            ]) */
            
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carpooling::class,
        ]);
    }
}
