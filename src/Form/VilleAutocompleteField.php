<?php

namespace App\Form;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;
use Symfony\Component\Validator\Constraints\Count;

#[AsEntityAutocompleteField]
class VilleAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'class' => Ville::class,
            'searchable_fields' => ['nom'],
            'placeholder' => 'Choisir une ou plusieur ville',
            'multiple' => true,
            'constraints' => [
                new Count(min: 1, minMessage: 'Besoin de choisir *quelque chose*'),
            ],

          

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
