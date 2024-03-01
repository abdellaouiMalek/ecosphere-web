<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Historique;
use App\Entity\Objet;
use App\Form\HistoriqueType;
use App\Form\ObjetType;
use App\Repository\HistoriqueRepository;
use App\Repository\ObjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/historique')]
class HistoriqueController extends AbstractController
{
    #[Route('/', name: 'app_historique_index', methods: ['GET'])]
    public function index(HistoriqueRepository $historiqueRepository): Response
    {

        $historique=$this->getDoctrine()->getRepository(historique::class)->findAll();

        return $this->render('historique/index.html.twig', [
            'historiques' => $historiqueRepository->findAll(),
        ]);
    }


#ajout dynamique a traver formulaire 
    #[Route('/new', name: 'app_historique_new', methods: ['GET', 'POST'])]
    public function new(ManagerRegistry $manager,Request $request): Response
    {
        $em = $manager->getManager();
        $historique = new Historique();
        $historique->setDate(new \DateTime()); // Définir la date actuelle
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($historique);
            $em->flush();

            return $this->redirectToRoute('app_historique_index');
        }

        return $this->renderForm('historique/new.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
        
    }
 #afficher liste 
    #[Route('/{id}', name: 'app_historique_show',methods: ['GET'])]
    public function show(Historique $historique , HistoriqueRepository $historiqueRepository): Response
    {
        $historique = $historiqueRepository->findAll();
        return $this->render('historique/show.html.twig', [
            'historiques' => $historique,
        ]);

        
    }


#mise a jour 
    #[Route('/edit/{id}', name: 'app_historique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,ManagerRegistry $manager, $id, HistoriqueRepository $HistoriqueRepository): Response
    {
        $historique= $this->getDoctrine()->getManager()->getRepository(historique::class)->find($id);
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $managerRegistry->getManager();
            //$em->persist($historique);
            $em->flush();   

            return $this->redirectToRoute('app_historique_index');
        }

        return $this->renderForm('historique/edit.html.twig'
          ,array('form'=>$form));
    }


 #delete 
    #[Route('/{id}', name: 'app_historique_delete', methods: ['POST'])]
    public function delete(Request $request, Historique $historique, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historique->getId(), $request->request->get('_token'))) {
            $entityManager->remove($historique);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
    }


}
