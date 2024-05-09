<?php

namespace App\Form;

use App\Entity\Manifestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Entity\Countries as Pays;
use App\Repository\CountriesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Ville;
use App\Repository\VilleRepository;

class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreFr', TextType::class, ['label' => false])
            ->add('titreDe', TextType::class, ['label' => false])
            ->add('titreEn', TextType::class, ['label' => false])
            ->add('date_debut', DateType::class, [
                'attr' => [
                    'type' => "date",
                    'id' => "date_debut"
                ]

            ])
            ->add('date_fin', DateType::class, [
                'attr' => [
                    'type' => "date",
                    'id' => "date_fin"
                ]
            ])
            ->add('duree', TextType::class, [
                'attr' => [
                    'readonly' => true,
                    'id' => "duree"
                ]
            ])
            ->add('justification_duree', TextareaType::class, [
                'attr' => [
                    'rows' => 5,
                    'cols' => 33,
                    'id' => "justification_duree"
                ]
            ])

            ->add(
                'countries',
                EntityType::class,
                [
                    'class' => Pays::class,
                    'choice_label' => 'nom',
                    'multiple' => true,
                    'autocomplete' => true,
                    'query_builder' => function (CountriesRepository $er) {
                        return $er->createQueryBuilder('pays')
                            ->orderBy('CASE WHEN pays.nom IN (:countries) THEN 0 ELSE 1 END', 'ASC')
                            ->setParameter('countries', ['Germany', 'France'])
                            ->addOrderBy('pays.nom', 'ASC');
                    },
                ]
            )
            ->add('ville', EntityType::class, [
                'class' => Ville::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'autocomplete' => true,
                'query_builder' => function (VilleRepository $er) {
                    return $er->createQueryBuilder('ville')
                        ->orderBy('ville.nom', 'ASC');
                },
            ])
            ->add('autre_ville', TextType::class, [
                'required' => false,
                'attr' => [
                    'id' => "autre_ville"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manifestation::class,
        ]);
    }
}
