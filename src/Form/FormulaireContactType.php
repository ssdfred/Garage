<?php

namespace App\Form;

use App\Entity\FormulaireContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulaireContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
          // ->add ('sujet' , CollectionType::class, array(
          //     'entry_type' => VoitureType::class,
          //     'by_reference' => 'voiture.nom',
          //     'allow_add' => true,
          //     'disabled' => false,
          //     'prototype' => true,
          //     'allow_delete' => true,
           //     'label' => false,

           // ))
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
        ]);
    }
}
