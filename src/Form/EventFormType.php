<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;









class EventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('eventName',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('address',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date',DateType::class, [
                'constraints' => [
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'Please enter a valid date.',
                    ]),
                ],
            ])
            ->add('time',TimeType::class, [
                'constraints' => [
                    new GreaterThanOrEqual(['value' => '08:00',
                    'message' => 'Please enter a valid date.',]), 
                    new LessThanOrEqual(['value' => '18:00',
                    'message' => 'Please enter a valid date.',]),
                ],
            ])
            ->add('location',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('objective',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('image')
            ->add('submit',SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
