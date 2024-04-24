<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Discipline;


class DisciplineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', ChoiceType::class, [
                'label' => 'Discipline',
                'choices' => [
                    'Sciences de l’ingénieur / Architecture' => [
                        'Génie Civil' => 'Génie Civil',
                        'Génie chimique et biotechnologique / Environnement / Énergies renouvelables' => 'Génie chimique et biotechnologique / Environnement / Énergies renouvelables',
                        'Génie électrique et électrotechnique / Génie informatique' => 'Génie électrique et électrotechnique / Génie informatique',
                        'Génie mécanique et mécatronique / Sciences des Matériaux / Génie des Matériaux' => 'Génie mécanique et mécatronique / Sciences des Matériaux / Génie des Matériaux',
                        'Ingénierie technico-commerciale' => 'Ingénierie technico-commerciale',
                        'Architecture' => 'Architecture',
                    ],
                    'Sciences / Mathématiques / Informatique' => [
                        'Biologie / Chimie' => 'Biologie / Chimie',
                        'Mathématiques / Physique' => 'Mathématiques / Physique',
                        'Informatique' => 'Informatique',
                        'Sciences de la vigne' => 'Sciences de la vigne',
                    ],
                    'Économie et Gestion' => [
                        'Économie / Gestion' => 'Économie / Gestion',
                        'Tourisme' => 'Tourisme',
                    ],
                    'Droit' => [
                        'Droit européen / international' => 'Droit européen / international',
                        'Droit franco-allemand' => 'Droit franco-allemand',
                        'Droit public' => 'Droit public',
                    ],
                    'Sciences humaines et sociales' => [
                        'Histoire' => 'Histoire',
                        'Études interculturelles' => 'Études interculturelles',
                        'Lettres / Langues / Communication' => 'Lettres / Langues / Communication',
                        'Musicologie' => 'Musicologie',
                        'Sciences politiques et sciences sociales' => 'Sciences politiques et sciences sociales',
                        'Journalisme' => 'Journalisme',
                        'Culture / Art & Média' => 'Culture / Art & Média',
                        'Administration publique / Management' => 'Administration publique / Management',
                        'Philosophie' => 'Philosophie',
                        'Études culturelles' => 'Études culturelles',
                        'Sciences du langage, linguistique' => 'Sciences du langage, linguistique',
                        'Histoire ancienne / Sciences de l’antiquité' => 'Histoire ancienne / Sciences de l’antiquité',
                    ],
                    'Formation des enseignants' => [
                        'Formation des enseignants' => 'Formation des enseignants',
                    ],
                    'Médecine' => [
                        'Médecine' => 'Médecine',
                    ],
                    'Autres' => [
                        'Autres : à remplir' => 'Autres : à remplir',
                    ],
                ],
                'multiple' => false, // Permet à l'utilisateur de sélectionner une seule discipline
                'mapped' => false, // Ne mappe pas ce champ à l'entité Project
                'autocomplete' => true,
            ])
            // Ajoutez d'autres champs si nécessaire (par exemple, un champ pour la description de la discipline) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Discipline::class,
        ]);
    }
}
