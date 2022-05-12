<?php

namespace App\Form\Type;

use App\Entity\Recetas;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class RecetasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            ->add('tipo', TextType::class)
            ->add('cant', IntegerType::class)
            ->add('dificultad', TextType::class)
            ->add('imagen', TextType::class)
            ->add('Guardar_Receta', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recetas::class,
        ]);
    }
}