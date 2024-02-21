<?php

namespace App\Form;

use App\Entity\BlogPost;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class BlogPostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('user')
            ->add('title',TextType::class,[
                'label'=>'Enter Title',
                'attr' => [
                      'placeholder' => 'Title' 
                ]
            ])
            ->add('content',TextareaType::class,[
                'attr' => [
                      'placeholder' => 'TypeYourText' 
                ]
            ])
            ->add('pubDate')
            ->add('reaction')
            ->add('comment')
            ->add('save',SubmitType::class,[
                'attr' =>[
                    'class' =>'btn btn-primary'               
                     ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BlogPost::class,
        ]);
    }
}
