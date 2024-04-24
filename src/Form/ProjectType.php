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
use App\Enum\TypeProjet;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num_dossier')
            ->add('titreFr')
            ->add('titreDe')
            ->add('titreEn')
            
            ->add('type', EnumType::class, [
                'class' => TypeProjet::class,
                'label' => 'Type de projet',
                'choice_label' => 'value',
                
            ])
            ->add('discipline', DisciplineType::class, [
                'label' => false,
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
