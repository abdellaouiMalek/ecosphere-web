<?php

namespace App\Controller;

use App\Entity\Carpooling;
use App\Form\CarpoolingType;
use App\Form\SearchCarpoolingType;
use App\Repository\CarpoolingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/carpooling')]
class CarpoolingController extends AbstractController
{
    #[Route('/search', name: 'searchCarpooling', methods: ['GET', 'POST'])]
    public function searchCarpooling(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SearchCarpoolingType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $departure = $formData['departure'];
            $destination = $formData['destination'];
            $departureDate = $formData['departureDate'];
            $time = $formData['time'];
            $price = $formData['price'];

            
            $results = $entityManager->getRepository(Carpooling::class)
                ->findBy([
                    'departure' => $departure,
                    'destination' => $destination,
                    'departureDate' => $departureDate,
                    'time' => $time,
                ]);
                var_dump($results);
    
            if (!empty($results)) {
                $this->addFlash('results', $results); 
                return $this->redirectToRoute('searchCarpoolingResult');
            } else {
                $this->addFlash('info', 'No matches found.');
            }
        }
        return $this->render('carpooling/searchCarpooling.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/search/result', name: 'searchCarpoolingResult', methods: ['GET'])]
    public function searchCarpoolingResult(Request $request): Response
    {
        $session = $request->getSession();
        $results = $this->get('session')->getFlashBag()->get('results'); 
        if (empty($results)) {
            $results = $request->query->get('results');
        }
      //  var_dump($results);
        $formattedResults = [];
if (!empty($results) && is_array($results)) {
    foreach ($results[0] as $carpooling) {
        $formattedResults[] = [
            'departure' => $carpooling->getDeparture(),
            'destination' => $carpooling->getDestination(),
            'departureDate' => $carpooling->getDepartureDate()->format('Y-m-d'), 
            'time' => $carpooling->getTime(),
            'price' => $carpooling->getPrice(),
        ];
    }
}

 $sortPrice = $request->query->get('sortPriceCheckbox');

        // Sort the results by price if the checkbox is checked
        if ($sortPrice) {
            usort($formattedResults, function($a, $b) {
                return $a['price'] <=> $b['price'];
            });
        }
        return $this->render('carpooling/carpoolingSearchResult.html.twig', [
            'results' => $formattedResults, 
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
        return $this->render('carpooling/carpoolingDetails.html.twig', [
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