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
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

class RecetasController extends AbstractController
{
    #[Route('/recetas', name: 'app_recetas')]
    public function index(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {

        
        $dql   = "SELECT a FROM App\Entity\Recetas a";
        $query = $em->createQuery($dql);
    
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        if (!$pagination) {
            throw $this->createNotFoundException(
                'No hay recetas en el sitio'
            );
        }
        return $this->render('recetas/index.html.twig', [
            'recetas' => $pagination
        ]);
    }
    
    #[Route('/mis-recetas', name: 'app_mis_recetas')]
    public function misRecetas(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {

        $user = $this->getUser();
        $id = $user->getId();
        $dql   = "SELECT a FROM App\Entity\Recetas a WHERE a.UserId = " . $id;
        $query = $em->createQuery($dql);
    
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        if (!$pagination) {
            throw $this->createNotFoundException(
                'No tienes recetas en el sitio'
            );
        }
        return $this->render('recetas/mis-recetas.html.twig', [
            'recetas' => $pagination
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
