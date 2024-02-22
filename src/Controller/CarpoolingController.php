<?php

namespace App\Controller;

use App\Entity\Carpooling;
use App\Form\CarpoolingType;
use App\Repository\CarpoolingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carpooling')]
class CarpoolingController extends AbstractController
{
    #[Route('/', name: 'app_carpooling_index', methods: ['GET'])]
    public function index(CarpoolingRepository $carpoolingRepository): Response
    {
        return $this->render('carpooling/index.html.twig', [
            'carpoolings' => $carpoolingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_carpooling_new', methods: ['GET', 'POST'])]
    public function addCarpooling(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carpooling = new Carpooling();
        $form = $this->createForm(CarpoolingType::class, $carpooling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carpooling);
            $entityManager->flush();

            return $this->redirectToRoute('app_carpooling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carpooling/addCarpooling.html.twig', [
            'carpooling' => $carpooling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carpooling_show', methods: ['GET'])]
    public function getCarpooling(Carpooling $carpooling): Response
    {
        return $this->render('carpooling/show.html.twig', [
            'carpooling' => $carpooling,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_carpooling_edit', methods: ['GET', 'POST'])]
    public function updateCarpooling(Request $request, Carpooling $carpooling, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarpoolingType::class, $carpooling);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_carpooling_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('carpooling/updateCarpooling.html.twig', [
            'carpooling' => $carpooling,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_carpooling_delete', methods: ['POST'])]
    public function deleteCarpooling(Request $request, Carpooling $carpooling, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carpooling->getId(), $request->request->get('_token'))) {
            $entityManager->remove($carpooling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_carpooling_index', [], Response::HTTP_SEE_OTHER);
    }
}
