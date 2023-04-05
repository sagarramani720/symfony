<?php

namespace App\Controller;

use App\Entity\Testing;
use App\Form\TestingType;
use App\Repository\TestingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

/**
 * @Route("/users")
 */
class TestingController extends AbstractController
{
    /**
     * @Route("/", name="users_index", methods={"GET"})
     */
    public function index(TestingRepository $testingRepository): Response
    {
        return $this->render('/users/index.html.twig', [
            'users' => $testingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/createUser", name="new", methods={"GET","POST"})
     */
    public function new(Request $request,  PersistenceManagerRegistry $doctrine): Response
    {
        $testing = new Testing();
        $form = $this->createForm(TestingType::class, $testing);
        $form = $this->createFormBuilder($testing) 
        ->add('name', TextType::class)
        ->add('email', TextType::class) 
        ->add('phone', IntegerType::class)  
        ->add('city', TextType::class) 
        ->getForm();  
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($testing);
            $entityManager->flush();
            $this->addFlash('success', 'User Created Successfully');
            return $this->redirectToRoute('index');
        } 
        return $this->renderForm('users/new.html.twig', [
            'users' => $testing,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/showUser/{id}", name="show", methods={"GET"})
     */
    public function show(Request $request, Testing $testing): Response
    {
        return $this->render('users/show.html.twig', [
            'testing' => $testing,
        ]);
    }

    /**
     * @Route("/editUser/{id}", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Testing $testing, PersistenceManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(TestingType::class, $testing);
        $form = $this->createFormBuilder($testing) 
        ->add('name', TextType::class)
        ->add('email', TextType::class) 
        ->add('phone', IntegerType::class) 
        ->add('city', TextType::class) 
        ->getForm();  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $doctrine->getManager()->flush();
            $this->addFlash('success', 'User Updated successfully!');
            return $this->redirectToRoute('index');
        }

        return $this->renderForm('users/edit.html.twig', [
            'users' => $testing,
            'form' => $form,
        ]);
    }

    /**
     * @Route("deleteUser/{id}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Testing $testing, PersistenceManagerRegistry $doctrine): Response
    {
        if ($this->isCsrfTokenValid('delete' . $testing->getId(), $request->request->get('_token'))) {
            $entityManager = $doctrine->getManager();
            $entityManager->remove($testing);
            $entityManager->flush();
            $this->addFlash('success', 'User deleted successfully!');
        }
        return $this->redirectToRoute('index');
    }
}
