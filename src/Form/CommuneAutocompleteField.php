<?php

namespace App\Form;

use App\Entity\Commune;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;
use Symfony\Component\Validator\Constraints\Count;


#[AsEntityAutocompleteField]
class CommuneAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Commune::class,
            'placeholder' => 'Choisissez une Ville',
            'choice_label' => 'nom',
            'searchable_fields' => ['nom'],
            'constraints' => [
                new Count(min: 1, minMessage: 'Vous devez sélectionner au moins une ville'),
            ],

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
