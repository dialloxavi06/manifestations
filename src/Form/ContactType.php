<?php

namespace App\Form;

use App\DTO\ContactDTO;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'empty_data' => '',
                'label' => false
            ])
            ->add('email', EmailType::class, [
                'empty_data' => '',
                'label' => false
            ])
            ->add('subject', TextType::class, [
                'empty_data' => '',
                'label' => false
            ])
            ->add('message', TextAreaType::class, [
                'empty_data' => '',
                'label' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => false
            ])
            ->add('service', ChoiceType::class, [
                'choices' => [
                    'Comptabilité' => 'compta@demo.de',
                    'Support' => 'diallo@dfh-ufa.org',
                    'Commercial' => 'marketing@demo.fr',
                ],
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactDTO::class,
        ]);
    }
}
