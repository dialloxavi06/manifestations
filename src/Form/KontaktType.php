<?php

namespace App\Form;

use App\Entity\Kontakt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\IntitutionType;

class KontaktType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('titre')
            ->add('email')
            ->add('telefone')
            ->add(
                'institution',
                IntitutionType::class,
                [
                    'label' => false
                ]
            )
            ->add('adresse', AdresseType::class, ['label' => false])
            ->add('Ajouter', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Kontakt::class,
        ]);
    }
}
