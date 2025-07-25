<?php

namespace App\Form;

use App\Entity\Driver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class DriverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class,
            [
                'label' => 'Nom :',
                'required' => false,
                'constraints' => [new NotBlank(['message' => 'Renseignez le nom du chauffeur'])],
                'attr' => ['class' => 'formItem'],
                ])

            ->add('FirstName', TextType::class,
             [
                    'label' => 'Prénom :',
                    'required' => false,
                    'constraints' => [new NotBlank(['message' => 'Renseignez le prénom du chauffeur'])],

                    'attr' => ['class' => 'formItem'],
                ])

            ->add('PhoneNumber', NumberType::class,
            [
                'label' => 'Nnuméro de téléphone :',
                'required' => false,
                'constraints' => [new Length(['min' => 10,
                'minMessage' => 'Le numéro entré est trop court (moins de dix chiffres) pour être valide',
                'max' => 10,
                'maxMessage' => 'Le numéro entré est trop long (plus de dix chiffres) pour être valide'])]

            ])

            ->add('DrivingLicense', EntityType::class,
            [
                'label' => 'Permis de conduire :',
                'class' => DrivingLicense::class,
                'choice_label' => 'category',
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.category', 'ASC');
                    },
                    'multiple' => true,
                    'expanded' => false,
                    'autocomplete' => true,
                    'by_reference' => true,
                     'constraints' => [
                        new NotBlank(['message' => 'Indiquez le(s) permis détenu(s) par le chauffeur'])
                    ],
                    'attr' => ['class' => 'formItem'],
            ])

            ->add('RegistrationNumber', TextType::class,
            [
                'label' => 'Matricule :',
                'required' => false,
                'constraints' => [new NotBlank(['message' => 'Renseignez le matricule du chauffeur'])],
                'attr' => ['class' => 'formItem'],
                ])

            ->add('Status', CheckboxType::class,
                [
                    'label' => 'Actif :',
                    'required' => false,
                    'attr' => ['class' => 'formItem'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Driver::class,
            'sanitize_html' => true,
            
        ]);
    }
}
