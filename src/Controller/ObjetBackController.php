<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Form\ObjetType;
use App\Repository\ObjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Doctrine\Persistence\ManagerRegistry;


#[Route('/objet/back')]
class ObjetBackController extends AbstractController
{
    #[Route('/', name: 'app_objet_back_index', methods: ['GET'])]
    public function index(ObjetRepository $objetRepository): Response
    {
        return $this->render('objet_back/index.html.twig', [
            'objets' => $objetRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_objet_back_new', methods: ['GET', 'POST'])]
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
             return $this->redirectToRoute('app_objet_back_index', [], Response::HTTP_SEE_OTHER);
            //return $this->redirectToRoute('app_historique_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objet_back/new.html.twig', [
            'objet' => $objet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objet_back_show', methods: ['GET'])]
    public function show(Objet $objet): Response
    {
        return $this->render('objet_back/show.html.twig', [
            'objet' => $objet,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_objet_back_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objet $objet,ObjetRepository $ObjetRepository,FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(ObjetType::class, $objet);
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
    
            $ObjetRepository->save($objet, true);
            $flashy->info('Objet modifier !');

            return $this->redirectToRoute('app_objet_back_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objet_back/edit.html.twig', [
            'objet' => $objet,
            'form' => $form,
        ]);
    }
   

    #[Route('/{id}', name: 'app_objet_back_delete', methods: ['POST'])]
    public function delete(ManagerRegistry $managerRegistry, ObjetRepository $ObjetRepository,$id,FlashyNotifier $flashy)
    {
        $objet= $ObjetRepository->find($id);
        $em= $managerRegistry->getManager();

        $em->remove($objet);
        $em->flush();
        $flashy->error('Objet supprimer !');
        return $this->redirectToRoute('app_objet_back_index', [], Response::HTTP_SEE_OTHER);
    }
}
