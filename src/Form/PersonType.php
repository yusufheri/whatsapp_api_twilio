<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Person;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('groupe', EntityType::class, [
                'label' => 'Groupe',
                'class' => Group::class,
                'choice_label' => 'title',
                'attr' => [
                    'placeholder' => 'Sélectionnez le groupe du membre'
                ]
            ])
            ->add('name', TextType::class,[
                'label' => 'Nom (*)'
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Post nom',
                'required' => false
            ])
            ->add('phoneMain', TextType::class,[
                'label' => 'Numéro de téléphone',
            ])
            ->add('phoneSecond', TextType::class,[
                'label' => 'Autre numéro de téléphone',
                'required' => false
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Une petite description',
                'required' => false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
