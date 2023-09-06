<?php

namespace App\Form;

use App\Entity\FormulaireContact;
use App\Entity\Voiture;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ContactType extends AbstractType
{
    private $voitureRepository;

    public function __construct(VoitureRepository $voitureRepository)
    {
        $this->voitureRepository = $voitureRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder



        ->add('sujet', TextType::class, [
            'label' => 'Sujet',
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'id' => 'contact_sujet',
            ],
        ])
        ->add('anneeMiseCirculation', TextType::class, [
            'label' => 'Année de mise en circulation',
            'mapped' => false,
            'data' => 'anneeMiseCirculation',
            'disabled' => true,
            'required' => true,
            'attr' => [
                'class' => 'form-control',
                'id' => 'anneeMiseCirculation',
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
            'csrf_protection' => false,
           
            

        ]);
    }
    
}
