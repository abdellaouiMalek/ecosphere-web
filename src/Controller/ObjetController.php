<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Form\ObjetType;
use App\Repository\ObjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\EditformType;
use MercurySeries\FlashyBundle\FlashyNotifier;

#[Route('/objet')]
class ObjetController extends AbstractController
{
    #[Route('/', name: 'app_objet_index', methods: ['GET'])]
    public function index(ObjetRepository $ObjetRepository): Response
    {
        return $this->render('objet/index.html.twig', [
            'objets' => $ObjetRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_objet_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ObjetRepository $ObjetRepository,FlashyNotifier $flashy): Response
    {
        $objet = new Objet();
        $form = $this->createForm(ObjetType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Picture = $form->get('Picture')->getData();
        
                if ($Picture) {
                    $newFilename = uniqid().'.'.$Picture->guessExtension();
                    $Picture->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                    $objet->setPicture($newFilename);
                }
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($objet);
            $entityManager->flush();
            $flashy->success('Objet Ajouter !');
            return $this->redirectToRoute('app_objet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objet/new.html.twig', [
            'objet' => $objet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objet_show', methods: ['GET'])]
    public function show(Objet $objet): Response
    {
        return $this->render('objet/show.html.twig', [
            'objet' => $objet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objet_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objet $objet,ObjetRepository $ObjetRepository): Response
    {
        $form = $this->createForm(EditformType::class, $objet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Picture = $form->get('Picture')->getData();
    
            if ($Picture) {
                // Delete the existing Picture
                $existingPicture = $objet->getPicture();
                if ($existingPicture) {
                    $filesystem = new Filesystem();
                    $filesystem->remove($this->getParameter('upload_directory').'/'.$existingPicture);
                }
    
                // Upload the new Picture
                $newFilename = uniqid().'.'.$Picture->guessExtension();
                $Picture->move(
                    $this->getParameter('upload_directory'),
                    $newFilename
                );
                $objet->setPicture($newFilename);
            }
    
            $objetRepository->save($objet, true);

            return $this->redirectToRoute('app_objet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objet/edit.html.twig', [
            'objet' => $objet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objet_delete', methods: ['POST'])]
    public function delete(Request $request, Objet $objet, ObjetRepository $ObjetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objet->getId(), $request->request->get('_token'))) {
            $ObjetRepository->remove($objet);
            $ObjetRepository->flush();
        }

        return $this->redirectToRoute('app_objet_index', [], Response::HTTP_SEE_OTHER);
    }
}
