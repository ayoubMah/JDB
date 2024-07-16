<?php
// src/Form/StagiaireType.php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType; // Use PasswordType for password field
use Symfony\Component\Form\Extension\Core\Type\IntegerType; // Use IntegerType for admin_id field

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', TextType::class)
            ->add('login', TextType::class)
            ->add('admin_id', IntegerType::class, [
                'attr' => ['class' => 'border rounded w-full py-2 px-3 text-gray-700'],
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'border rounded w-full py-2 px-3 text-gray-700'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}

