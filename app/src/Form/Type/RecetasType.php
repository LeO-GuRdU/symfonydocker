<?php

namespace App\Form\Type;

use App\Entity\Recetas;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
            ->add('ingredientes', CollectionType::class, [
                // each entry in the array will be an "text" field
                'entry_type' => TextType::class,
                'allow_add' => true,
            ])
            ->add('pasos', CollectionType::class, [
                // each entry in the array will be an "text" field
                'entry_type' => TextType::class,
                'allow_add' => true,
            ])
            ->add('imagen', TextType::class)
            ->add('Guardar_Receta', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recetas::class,
        ]);
    }
}
