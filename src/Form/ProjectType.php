<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, [
                "label" => "Title",
                "required" => true,
                "attr" => [
                    "class" => "newProjectInputs"
                ]
            ])
            ->add("category", TextType::class, [
                "label" => "Category",
                "required" => true,
                "attr" => [
                    "class" => "newProjectInputs"
                ]
            ])
            ->add("description", TextType::class, [
                "label" => "Description",
                "required" => true,
                "attr" => [
                    "class" => "newProjectInputs"
                ]
            ])
            ->add("date", DateType::class, [
                "format"          => "dd MMM yyyy",
                "years"           => range(date("Y") + 1, date("Y") - 10),
                "days"            => [1],
                "html5" => false,
                "label" => "Date",
                "required" => true,
                "attr" => [
                    "class" => "newProjectInputs js-datepicker",
                ]
            ])

            ->add("pictures", CollectionType::class, [
                "entry_type" => PictureType::class,
                "entry_options" => [
                    "label" => false,
                ],
                "allow_add" => true,
                "allow_delete" => true,
                "prototype" => true,
                "attr" => [
                    "class" => "picturesSelectors",
                ],
                "required" => false,
                "by_reference" => false,
            ])

            ->add("save", SubmitType::class, [
                "label" => "Save",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Project::class,
            "csrf_protection" => true,
        ]);
    }
}
