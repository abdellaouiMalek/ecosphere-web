<?php

namespace App\Form;

use App\Entity\Historique;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
#use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            #->add('id')
            ->add('nom_o')#,TextType::class, [
                #'constraints' => [
                 #   new Assert\Regex([
                  #      'pattern' => '/^[a-zA-Z à é è  -- , ""]+$/u',
                   #     'message' => 'The name can only contain letters'
                    #])
                #]
            #])
            ->add('date' )
            ->add('initialCondition',ChoiceType::class, [
                'choices' => [
                    'Exellent' => 'Exellent',
                    'Good' => 'Good',
                    'Medium' => 'Medium',
                    'Bad' => 'Bad',
                ],
                ] )
            
    
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Historique::class,
            'nom_objet' => null,
        ]);
    }
}
