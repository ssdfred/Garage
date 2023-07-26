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

            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('numeroTelephone')
            ->add('message')
            ->add('voiture')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FormulaireContact::class,
        ]);
    }
}
