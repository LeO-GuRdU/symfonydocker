<?php

namespace App\Form\Type;

use App\Entity\Recetas;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class RecetasType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class)
            //->add('tipo', TextType::class)
            ->add('tipo', ChoiceType::class, array(
                'choices' => array('Desayuno/Merienda' => 'Desayuno/Merienda', 'Almuerzo/Cena' => 'Almuerzo/Cena', 'Postre' => 'Postre')
            ))
            ->add('cant', IntegerType::class)
            ->add('dificultad', ChoiceType::class, array(
                'choices' => array('Fácil' => 'Fácil', 'Media' => 'Media', 'Difícil' => 'Difícil')
            ))
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
            ->add('imagen', FileType::class, [
                'label' => 'Imagen de la receta.',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                    ])
                ],
            ])

            ->add('guardar', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recetas::class,
        ]);
    }
}
