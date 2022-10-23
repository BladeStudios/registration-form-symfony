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

class ClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('is_individual_client', ChoiceType::class, [
                'label' => 'Status prawny:',
                'expanded' => true,
                'multiple' => false,
                'empty_data' => null,
                'choices' => [
                    'klient indywidualny' => true,
                    'Firma' => false
                ]
            ])
            ->add('name', TextType::class, [
                'label' => 'Imię i nazwisko:',
                'empty_data' => ''
                ])
            ->add('street_name', TextType::class, [
                'label' => 'Ulica, nr domu:',
                'empty_data' => ''
                ])
            ->add('street_number', TextType::class, [
                'label' => false,
                'empty_data' => ''
                ])
            ->add('city', TextType::class, [
                'label' => 'Miejscowość, kod pocztowy:',
                'empty_data' => ''
            ])
            ->add('postal_code', TextType::class, [
                'label' => false,
                'empty_data' => ''
                ])
            ->add('voivodeship', ChoiceType::class, [
                'label' => 'Województwo:',
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Ładowanie listy województw...',
                'empty_data' => ''
                ])
            ->add('area_code', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => ' +48'
                ],
                'empty_data' => ''
                ])
            ->add('phone', TextType::class, [
                'label' => 'Telefon:',
                'empty_data' => ''
                ])
            ->add('email', TextType::class, [
                'label' => 'Email:',
                'empty_data' => ''
                ])
            ->add('pesel', TextType::class, [
                'label' => 'PESEL:',
                'required' => false,
                'empty_data' => null
                ])
            ->add('nip', TextType::class, [
                'label' => 'NIP:',
                'required' => false,
                'empty_data' => null
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
