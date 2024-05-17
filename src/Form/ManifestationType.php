<?php

namespace App\Form;

use App\Entity\Commune;
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
use App\Entity\Project;
use App\Entity\Region;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use App\Entity\Departement;





class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('project', EntityType::class, [
                'class' => Project::class,
                'choice_label' => function ($project) {
                    return $project->getTitreFr() . ' / ' . $project->getTitreDe();
                }
            ])

            ->add('titreFr', TextType::class, [
                'label' => false
            ])
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
                ],
                'required' => false
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
                            ->where('pays.nom NOT IN (:countries)')
                            ->orderBy('pays.nom', 'ASC')
                            ->setParameter('countries', ['Germany', 'France']);
                    },

                ]
            )
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir une région',
                'required' => false,
                'mapped' => false,
                'autocomplete' => true
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un département',
                'required' => false,
                'mapped' => false,
                'autocomplete' => true

            ])
            ->add('commune', CommuneAutocompleteField::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manifestation::class,
        ]);
    }


    private function addDepartementField(FormInterface $form, ?Region $region)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'departement',
            EntityType::class,
            null,
            [
                'class'           => Departement::class,
                'placeholder'     => $region ? 'Sélectionnez votre département' : 'Sélectionnez votre région',
                'mapped'          => false,
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $region ? $region->getDepartements() : []
            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addcommuneField($form->getParent(), $form->getData());
            }
        );
        $form->add($builder->getForm());
    }

    private function addcommuneField(FormInterface $form, ?Departement $departement)
    {
        $form->add('commune', EntityType::class, [
            'class'       => Commune::class,
            'placeholder' => $departement ? 'Sélectionnez votre commune' : 'Sélectionnez votre département',
            'choices'     => $departement ? $departement->getCommunes() : []
        ]);
    }
}
