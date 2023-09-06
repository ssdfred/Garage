<?php

namespace App\Form;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\FormulaireContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaireContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add ('sujet' , CollectionType::class, array(
               'entry_type' => VoitureType::class,
              // 'by_reference' => 'voiture.nom',
              // 'allow_add' => true,
              // 'disabled' => false,
              // 'prototype' => true,
              // 'allow_delete' => true,
               'label' => false,

            ))
 
            ->add('anneeMiseCirculation', DateType::class, [
                'label' => 'Année de mise en circulation',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'widget' => 'single_text',
            ])
           ->add('sujet')
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('numeroTelephone')
            ->add('message')
            ->add('voiture')
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormulaireContact::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
        ]);
    }
}
