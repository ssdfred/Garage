<?php

namespace App\Form;

use App\Entity\FormulaireContact;
use App\Entity\Voiture;
use Doctrine\ORM\QueryBuilder;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormTypeInterface;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder


           ->add('sujet', EntityType::class, [
            'label' => 'sujet',
            'required' => true,
            'class' => Voiture::class,
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.titre');
            },
            'attr' => [
                'class' => 'form-control',
            ],
        ])
        ->add('voiture', EntityType::class, [
            'class' => Voiture::class,
            //'choice_label' => 'titre',
            'query_builder' => function (EntityRepository $er): QueryBuilder {
                return $er->createQueryBuilder('u')
                    ->orderBy('u.titre');
            },
           // 'choice_label' => 'titre',

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
