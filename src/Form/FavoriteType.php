<?php

namespace App\Form;

use App\Entity\Group;
use App\Entity\Favorite;
use App\Repository\GroupRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FavoriteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('groupes', EntityType::class,[
                'label' => "Groupe ",
                'attr'  => [
                    'placeholder' => "Sélectionnez le groupe à envoyer le message",
                ],
                'class' => Group::class,
                'query_builder' => function(GroupRepository $groupRepository){
                    return $groupRepository->createQueryBuilder('g')
                                ->where("g.deletedAt IS NULL")
                                ->orderBy("g.title", "ASC");
                },
                'choice_label' => 'title',
                'multiple' => true
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Saisir votre message',
                'attr' => [
                    'rows' => 5
                ]
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Sélectionnez le fichier à joindre au message (5M maximum)',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Favorite::class,
        ]);
    }
}
