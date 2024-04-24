<?php

namespace App\Form;

use App\Entity\Manifestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            ->add('titreFr', null, [
                'label' => 'Titre en français',
            ])
            ->add('titreDe', null, [
                'label' => 'Titre en allemand',
            ])
            ->add('titreEn', null, [
                'label' => 'Titre en anglais',
            ])
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
          ->add('justification_pays_tiers', TextAreaType::class, [
              'label' => 'Justification pays tiers',
          ])

          ->add('pays', ChoiceType::class, [
            'choices' => [
                'France' => 'FR',
                'Allemagne' => 'DE',
            ],
            'placeholder' => 'Sélectionner un pays',
            'required' => false,
        ]);

    
$builder->get('pays')->addEventListener(FormEvents::POST_SUBMIT, 
function (FormEvent $event) {
    $form = $event->getForm();
    $manifestation = $event->getForm()->getData();
    

    // Vérifiez si les données existent et que le pays est défini
    if ($manifestation) {
        $cities = $this->getCitiesForCountry($manifestation);

        // Mettre à jour les options pour le champ de la ville
        $form->getParent()->add('ville', ChoiceType::class, [
            'choices' => $cities,
            'placeholder' => 'Sélectionner une ville',
            'required' => true,
        ]);
    }
});

}

private function getCitiesForCountry(string $country): array
{
    // Ici, vous devriez implémenter la logique pour obtenir les villes du pays donné
    // Cela pourrait impliquer une requête à une base de données ou un appel à une API de géolocalisation
    // Pour cet exemple, je vais simplement renvoyer un tableau statique

  
    if ($country === 'FR') {
        return [
            'Paris' => 'Paris',
            'Marseille' => 'Marseille',
            'Lyon' => 'Lyon',
            'Toulouse' => 'Toulouse',
            'Nice' => 'Nice'
        ];
    } elseif ($country === 'DE') {
        return [
            'Berlin' => 'Berlin',
            'Hambourg' => 'Hambourg',
            'Munich' => 'Munich',
            'Cologne' => 'Cologne',
            'Francfort' => 'Francfort'
        ];
    } else {
        return [];
    }
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Manifestation::class,
        ]);
    }
}

