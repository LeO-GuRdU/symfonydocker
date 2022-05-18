<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Recetas;
use App\Repository\RecetasRepository;
use App\Form\Type\RecetasType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;

class RecetasController extends AbstractController
{
    #[Route('/recetas', name: 'app_recetas')]
    public function index(RecetasRepository $recetasRepository): Response
    {

        $recetas = $recetasRepository->findAll();

        if (!$recetas) {
            throw $this->createNotFoundException(
                'No hay recetas en el sitio'
            );
        }
        return $this->render('recetas/index.html.twig', [
            'recetas' => $recetas
        ]);
    }

    #[Route('/recetas/new', name: 'nueva_receta')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
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

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $newreceta = new Recetas();
            $entityManager = $doctrine->getManager();
            $newreceta = $form->getData();
            $user = $this->getUser();
            $newreceta->setUserId($user);
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($newreceta);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return new Response('Saved new product with id '.$newreceta->getId());
        }

        return $this->renderForm('recetas/new.html.twig', [
            'form' => $form,
        ]);
    }
}
