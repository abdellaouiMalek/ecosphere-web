<?php

namespace App\Controller;

use App\Entity\Objet;
use App\Form\Objet1Type;
use App\Repository\ObjetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/objetfrontt')]
class ObjetFronttController extends AbstractController
{
    #[Route('/', name: 'app_objet_frontt_index', methods: ['GET'])]
    public function index(ObjetRepository $objetRepository): Response
    {
        return $this->render('objet_frontt/index.html.twig', [
            'objets' => $objetRepository->findAll(),
        ]);
    }

    #[Route('/show', name: 'app_objet_frontt_show', methods: ['GET'])]
    public function show(Objet $Objet): Response
    {
        $historique = [];

        foreach ($Objet->getHistorique() as $historique) {
            if ($historique->getObjet()->getId() === $Objet->getId()) {
                $historique[] = $historique->getNom();
            }
        }

        return $this->render('Objet_frontt/show.html.twig', [
            'Objet' => $Objet,
            'historique' => $historique,
        ]);
    }


}
