<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Passwords do not match",
                "label" => "Password",
                "required" => true,
                "constraints" => [
                    new Length([
                        "min" => 6,
                        "max" => 30,
                        "minMessage" => "Your password must be more than 5 characters.",
                        "maxMessage" => "Your password must be less than 31 characters.",
                    ]),
                    new NotBlank(),
                    new Regex([
                        "pattern" => "/^\S+$/",
                        "message" => "Don't use space in your new password."
                    ])
                ],
                "options" => ["attr" => ["class" => "password-field"]],
                "first_options" => ["label" => "Enter your new password"],
                "second_options" => ["label" => "Re-Enter your new password"],
            ])
            ->add("save", SubmitType::class, [
                "label" => "Change my password",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "csrf_protection" => true
        ]);
    }
}
