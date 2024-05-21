<?php

namespace App\Form;

use App\Entity\Staedte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class StaedteAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Staedte::class,
            'placeholder' => 'Choose a Staedte',
            'choice_label' => 'nom',
            'multiple' => true,
            'query_builder' => function ($er) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.nom', 'ASC');
            },

            // choose which fields to use in the search
            // if not passed, *all* fields are used
            // 'searchable_fields' => ['name'],

            // 'security' => 'ROLE_SOMETHING',
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
