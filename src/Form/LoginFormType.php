<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;


class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese su email',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Contraseña',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese su contraseña',
                    ]),
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults(['csrf_protection' => true, 'mapped' => false]);
    }

    public function getBlockPrefix():string
    {
        return '';
    }
}
