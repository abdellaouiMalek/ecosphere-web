<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Historique;
use App\Entity\Objet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
#use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           # ->add('id')
           ->add('nom_o')#,TextType::class, [
            #'constraints' => [
             #   new Assert\Regex([
              #      'pattern' => '/^[a-zA-Z à é è  -- , ""]+$/u',
               #     'message' => 'The name can only contain letters'
                #])
            #]
        #])
            ->add('Type',ChoiceType::class, [
                'choices' => [
                    'Clothes' => 'Clothes',
                    'Machine' => 'Machine',
                    'Accesory' => 'Accesory',
                    'Medical Machine' => 'Medical Machine',
                    'house ware' => 'house ware',
                ],
                ])
            ->add('Picture',FileType::class,['mapped'=>false])
            ->add('Age')
          #  ->add('historique',EntityType::class,[
           #     'class' => Historique::class,
            #    'choice_label' => 'date',
             #   'label'=> 'historique'
            #])
            ->add('description',ChoiceType::class, [
                'choices' => [
                    'Exellent' => 'Exellent',
                    'Good' => 'Good',
                    'Medium' => 'Medium',
                    'Bad' => 'Bad',
                ],
                ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
        ]);
    }
}
