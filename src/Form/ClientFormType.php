<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_individual_client', ChoiceType::class, [
                'label' => 'Status prawny:',
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    'klient indywidualny' => true,
                    'Firma' => false
                ]
            ])
            ->add('name', TextType::class, ['label' => 'Imię i nazwisko:'])
            ->add('street_name', TextType::class, ['label' => 'Ulica, nr domu:'])
            ->add('street_number', TextType::class, ['label' => false])
            ->add('city', TextType::class, ['label' => 'Miejscowość, kod pocztowy:'])
            ->add('postal_code', TextType::class, ['label' => false])
            ->add('voivodeship', ChoiceType::class, [
                'label' => 'Województwo:',
                'expanded' => false,
                'multiple' => false
                ])
            ->add('area_code', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => ' +48'
                ]
                ])
            ->add('phone', TextType::class, ['label' => 'Telefon:'])
            ->add('email', TextType::class, ['label' => 'Email:'])
            ->add('pesel', TextType::class, ['label' => 'PESEL:'])
            ->add('nip', TextType::class, [
                'label' => 'NIP:',
                'required' => false
                ])
            ->add('cancel', ButtonType::class, ['label' => 'ANULUJ'])
            ->add('save', SubmitType::class, ['label' => 'ZAPISZ'])
            ->get('voivodeship')->resetViewTransformers()
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
