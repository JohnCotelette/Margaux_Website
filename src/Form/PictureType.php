<?php

namespace App\Form;

use App\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Validator\Constraints\File;

class PictureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("file", VichFileType::class, [
                "label" => "New Picture",
                "attr" => [
                    "class" => "newPictureContainer",
                ],
                "required" => true,
                "constraints" => [
                    new File([
                        "maxSize" => "20M",
                        "maxSizeMessage" => "Your file is too big (20M max).",
                        "mimeTypes" => [
                            "image/jpeg",
                            "image/gif",
                            "image/png",
                        ],
                        "mimeTypesMessage" => "You can only upload jpeg/gif/pnf files.",
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Picture::class,
        ]);
    }
}
