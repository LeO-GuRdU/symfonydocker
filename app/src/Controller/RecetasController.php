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
use App\Service\FileUploader;

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
    public function new(Request $request, ManagerRegistry $doctrine, FileUploader $fileUploader): Response
    {
        // creates a receta object and initializes some data for this example
        $receta = new Recetas();

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
            $imageFile = $form->get('imagen')->getData();
            if ($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $newreceta->setImagen($imageFileName);
            }
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

    #[Route('/recetas/{id}', name: 'ver-receta')]
    public function verReceta($id,Request $request,RecetasRepository $recetasRepository): Response
    {

        $receta = $recetasRepository->find($id);

        if (!$receta) {
            throw $this->createNotFoundException(
                'Vaya, no existe esa receta!'
            );
        }
        return $this->render('recetas/ver-receta.html.twig',['receta'=>$receta]);
    }
}
