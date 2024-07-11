<?php

// src/Form/StagiaireType.php

namespace App\Form;

use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('admin_id')
            ->add('login')
            ->add('password', PasswordType::class, [
                'mapped' => false, // Ensures the field is not mapped to the entity, so it doesn't overwrite the password in the database unless explicitly handled
                'required' => false, // Makes it optional to fill in, so the password is only updated if a new value is provided
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}


