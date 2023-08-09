<?php

namespace App\Form;

use App\Entity\FormulaireContact;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//use App\Component\Form\VoitureType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
//use App\Entity\FormulaireContact;
use App\Form\VoitureType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

            ->add('sujet', CollectionType::class, [
                'entry_type' => VoitureType::class,
                'by_reference' => 'voiture_id',
                'allow_add' => true,
                'disabled' => true,
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

        ]);
    }
}
