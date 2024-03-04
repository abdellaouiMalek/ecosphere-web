<?php

namespace App\Form;

use App\Entity\Carpooling;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddDateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('arrivalDate', DateType::class ,  [
            'constraints' => [
                new NotBlank(['message' => 'You have to mention the date',
            ]),
            ] 
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Carpooling::class,
        ]);
    }
}
