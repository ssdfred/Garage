<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;
class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextType::class)
            ->add('prix', NumberType::class)
            ->add("image", FileType::class, [
                "label" => "L'image",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            "image/gif",
                            "image/png",
                            "image/svg+xml",
                            "image/jpg",
                            "image/webp"
                        ],
                        'mimeTypesMessage' => 'Veuillez proposer une image valide.',
                    ])
                ],
            ])
            ->add('anneeMiseCirculation', DateType::class, [
              'label' => 'Année de mise en circulation',
              'format' => 'dd/MM/yyyy',
              'html5' => false,
              'widget' => 'single_text',
          ])
            ->add('kilometrage', NumberType::class)
            ->add("galerieImages", FileType::class, [
                "label" => "Galerie d'images",
                'mapped' => false,
                "required" => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            "image/gif",
                            "image/png",
                            "image/svg+xml",
                            "image/jpg",
                            "image/webp"
                        ],
                        'mimeTypesMessage' => 'Veuillez proposer une image valide.',
                    ])
                ],
            ])
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
