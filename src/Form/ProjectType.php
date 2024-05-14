<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\TypeProject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use App\Entity\Discipline;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titreFr')
            ->add('titreDe')
            ->add('titreEn')
            ->add('type_project', EntityType::class, [
                'class' => TypeProject::class,
                'choice_label' => 'nom',
            ])
            ->add('discipline', EntityType::class, [
                'class' => Discipline::class,
                'choice_label' => 'nom',
                'label' => false,
                'choice_translation_domain' => 'messages',
                'autocomplete' => true,
                'placeholder' => 'Sélectionner une discipline'
            ]);

        // Ajout de l'événement FormEvents::SUBMIT
        $builder->addEventListener(FormEvents::SUBMIT, [$this, 'onSubmit']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }

    // Méthode pour générer le numéro de dossier
    public function onSubmit(FormEvent $event)
    {
        $project = $event->getData();
        $annee = date('y'); // Obtenez les deux derniers chiffres de l'année actuelle
        $numDossier = '';

        // Générer le numéro de dossier si non défini
        if (!$project->getNumDossier()) {
            $typeProjet = $project->getTypeProject()->getId(); // Supposons que getTypeProject() renvoie une entité TypeProject
            if ($typeProjet == 1) {
                $typeProjet = '';
            } else if ($typeProjet == 2) {
                $typeProjet = '-KI';
            }

            // Supposons que vous avez déjà une méthode pour obtenir le mois de dépôt du dossier
            $moisDepot = $project->getMoisCreatedAt(); // Supposons que cette méthode retourne le mois de dépôt du projet
            $rounde = '';

            if ($moisDepot >= 1 && $moisDepot <= 3) {
                $rounde = '1';
            } elseif ($moisDepot >= 4 && $moisDepot <= 6) {
                $rounde = '2';
            } elseif ($moisDepot >= 7 && $moisDepot <= 9) {
                $rounde = '3';
            }
            $numDossierManifestation = 'NBV-' . $moisDepot . $typeProjet . '-' . $annee . '-' . $rounde;

            // Ajouter le numéro de dossier de chaque manifestation au numéro de dossier global
            $numDossier .= ($numDossier == '') ? $numDossierManifestation : ', ' . $numDossierManifestation;
        }


        $project->setNumDossier($numDossier);
    }
}
