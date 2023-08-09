<?php

namespace App\Form;

use App\Entity\FormulaireContact;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

        //    ->add('sujet', CollectionType::class, array(
        //        'entry_type' => VoitureType::class,
        //        'by_reference' => 'voiture',
        //        'allow_add' => true,
        //        'disabled' => false,
        //        'prototype' => true,
        //        'allow_delete' => true,
        //        'label' => false,
//
        //    ))

            ->add('sujet', TextType::class, [
                'label' => 'Sujet',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Votre e-mail',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('numeroTelephone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('envoyer', SubmitType::class, [
                'label' => 'Envoyer',
                'validation_groups' => ['Registration'],
                'attr' => [
                    'class' => 'form-control',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormulaireContact::class,
            'voiture' => 'voiture.nom',

        ]);
    }
}
