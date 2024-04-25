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
use Symfony\Component\HttpClient\HttpClient;


class ManifestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('titreFr', null, [
                'label' => false,
            ])
            ->add('titreDe', null, [
                'label' => false,
            ])
            ->add('titreEn', null, [
                'label' => false,
            ])
            ->add('date_debut', null, [
                'widget' => 'single_text',
                'label' => false,
            ])
            ->add('date_fin', null, [
                'widget' => 'single_text',
                'label' => false,
            ])
            ->add('duree', null, [
                'label' => false,
            ])
            ->add('justification_duree', TextAreaType::class, [
                'label' => false,
            ])


            ->add('pays', ChoiceType::class, [
                'choices' => [
                    'France' => 'FR',
                    'Allemagne' => 'DE',
                    'Autre' => 'AU'
                ],
                'placeholder' => 'Sélectionner un pays',
                'required' => false,
                'label' => false,
            ]);


        $builder->get('pays')->addEventListener(
            FormEvents::POST_SUBMIT,
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
            }
        );
    }

    private function getCitiesForCountry(string $country): array
    {
        // Ici, vous devriez implémenter la logique pour obtenir les villes du pays donné
        // Cela pourrait impliquer une requête à une base de données ou un appel à une API de géolocalisation
        // Pour cet exemple, je vais simplement renvoyer un tableau statique


        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'https://geo.api.gouv.fr/communes');

        $cities = $response->toArray();

        if ($country === 'FR') {

            foreach ($cities as $city) {
                dd($cities[$city['nom']] = $city['nom']);
            }
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
