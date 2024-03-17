<?php

namespace App\Controller;

use App\Entity\Carpooling;
use App\Form\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request): Response
    {
        $carpooling = new Carpooling();

        $form = $this->createForm(TestType::class, $carpooling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the submitted data
            $data = $form->getData();

            // Save the data to the database (replace this with your logic)
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            // Redirect or return a response as needed
            return $this->redirectToRoute('app_home');
        }

        return $this->render('test/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}