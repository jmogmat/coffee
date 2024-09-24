<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor ingrese un email',
                    ]),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Contraseña',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Por favor ingrese una contraseña',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres',
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Confirmar contraseña',
                ],
                'invalid_message' => 'Las contraseñas no coinciden',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver):void
    {
        $resolver->setDefaults(['csrf_protection' => true, 'mapped' => true]);
    }

    public function getBlockPrefix():string
    {
        return '';
    }
}
