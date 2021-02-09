<?php

namespace App\Form;

use App\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du groupe',
                'attr' => [
                    'placeholder' => 'Saisir un nom '
                ]
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Commentaire',
                'required' => false,              
                'attr' => [
                    'placeholder' => 'Faites une petite description de ce groupe',
                    'rows' => 5
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
