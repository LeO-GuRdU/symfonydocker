<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Recetas;
use App\Form\Type\RecetasType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;

class RecetasController extends AbstractController
{
    #[Route('/recetas', name: 'app_recetas')]
    public function index(): Response
    {

        return $this->render('recetas/index.html.twig', [
            'controller_name' => 'RecetasController',
        ]);
    }

    public function new(Request $request): Response
    {
        // creates a receta object and initializes some data for this example
        $receta = new Recetas();
        $receta->setNombre('Titulo de la receta');
        $receta->setTipo('Tipo de receta');
        $receta->setCant(2);
        $receta->setDificultad('Dificultad de la receta');
        $receta->setImagen('Imagen de la receta');


        $form = $this->createFormBuilder($receta)
            ->add('nombre', TextType::class)
            ->add('tipo', TextType::class)
            ->add('cant', IntegerType::class)
            ->add('dificultad', TextType::class)
            ->add('imagen', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Guardar Receta'])
            ->getForm();

        $form = $this->createForm(RecetasType::class, $receta);

        return $this->renderForm('recetas/new.html.twig', [
            'form' => $form,
        ]);
    }
}
