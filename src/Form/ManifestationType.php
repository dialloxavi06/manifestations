<?php

namespace App\Form;

use App\Entity\Manifestation;
use App\Entity\Pays;
use App\Entity\Project;
use App\Form\VilleAutocompleteField as FormVilleAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;

class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('titre')
            ->add('date_debut', null, [
                'widget' => 'single_text',
                'label' => 'Date de début',
            ])
            ->add('date_fin', null, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
            ])
            ->add('duree')
            ->add('justification_duree', TextAreaType::class, [
                'label' => 'Justification de la durée',
            ])
            ->add('project_id', EntityType::class, [
                'class' => Project::class,
                'choice_label' => 'titre',
                'label' => 'Projet',
            ])
            ->add('ville', FormVilleAutocompleteField::class, [
                'label' => 'Ville',
                'multiple' => true,
                'required' => false,
            ])
            ->add('pays', EntityType::class, [
              'class' => Pays::class,
              'choice_label' => 'nom',
              'autocomplete' => true,
              'label' => 'Pays',
              'placeholder' => 'Sélectionner le pays',
              'mapped' => false,
              'required' => false,
              'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('p')
                    ->orderBy('p.nom', 'ASC');
            },
          ])
           
          ->add('justification_pays_tiers', TextAreaType::class, [
              'label' => 'Justification pays tiers',
          ])

          ;
    

   
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manifestation::class,
        ]);
    }
}

