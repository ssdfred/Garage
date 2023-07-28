<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('prix', NumberType::class)
            ->add('image', TextType::class)
            ->add('anneeMiseCirculation', DateType::class, [
              'label' => 'Année de mise en circulation',
              'format' => 'dd/MM/yyyy',
              'years' => range(1900, date('Y')),
              'widget' => 'single_text',
          ])
            ->add('kilometrage', NumberType::class)
            ->add('galerieImages', TextType::class)
            ->add('caracteristiques', TextType::class)
            ->add('equipementsOptions', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
