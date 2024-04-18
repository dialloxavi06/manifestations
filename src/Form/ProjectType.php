<?php

namespace App\Form;

use App\Entity\Project;
use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Enum\StatutProjet;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_dossier')
            ->add('titre')
            ->add('statut', EnumType::class, [
                'class' => StatutProjet::class,
                'label' => 'Statut du projet',
            ])
            ->add('createdAt')
            ->add('submit', SubmitType::class, [
                'label' => 'Créer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
