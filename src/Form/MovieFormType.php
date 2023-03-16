<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TypeTextType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none mt-5',
                    'placeholder'=>'Enter Title'
                ),
                'label'=> false
            ])
            ->add('releaseYear', IntegerType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none mt-10',
                    'placeholder'=>'Enter Release Year..'
                ),
                'label'=> false
            ])
            ->add('description', TextareaType::class, [
                'attr'=>array(
                    'class'=>'bg-transparent block border-b-2 w-full h-20 text-6xl outline-none mt-10',
                    'placeholder'=>'Enter Description'
                ),
                'label'=> false
            ])
            ->add('imagePath', FileType::class, array(
                'required'=>false,
                'mapped'=>false
                ))
            // ->add('actors')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
