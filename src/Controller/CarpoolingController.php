<?php

namespace App\Controller;

use App\Entity\Carpooling;
use App\Form\AddDateType;
use App\Form\AddDestinationType;
use App\Form\AddTimeType;
use App\Form\CarpoolingType;
use App\Form\SearchCarpoolingType;
use App\Repository\CarpoolingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
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


            $results = $entityManager->getRepository(Carpooling::class)
                ->findBy([
                    'departure' => $departure,
                    'destination' => $destination,
                    'departureDate' => $departureDate,
                    'time' => $time,
                ]);

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
        // Format the results
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
    
        // Check if sorting is requested
        $sortPrice = $request->query->get('sortPrice');
        if ($sortPrice == '1') {
            // Sort the results by price in ascending order
            usort($formattedResults, function ($a, $b) {
                return $a['price'] - $b['price'];
            });
        }
    
        // Check if the request is an XMLHttpRequest (AJAX)
        if ($request->isXmlHttpRequest()) {
            // If it's an AJAX request, return JSON response
            return new JsonResponse(['results' => $formattedResults]);
        } else {
            // If it's not an AJAX request, render the Twig template
            return $this->render('carpooling/carpoolingSearchResult.html.twig', [
                'results' => $formattedResults,
            ]);
        }
    }

    #[Route('/new/addDeparture', name: 'app_carpooling_new_departure', methods: ['GET', 'POST'])]
public function addCarpooling(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
{
    $carpooling = new Carpooling();
    $form = $this->createForm(CarpoolingType::class, $carpooling);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Store the departure data in the session flash bag
        $session = $request->getSession();
         $this->get('session')->getFlashBag()->set('departure', $carpooling->getDeparture());
      /*  // Persist the carpooling entity to the database
        $entityManager->persist($carpooling);
        $entityManager->flush();
*/
        return $this->redirectToRoute('app_carpooling_new_destination');
    }

    return $this->renderForm('carpooling/addDeparture.html.twig', [
        'carpooling' => $carpooling,
        'form' => $form,
    ]);
}

#[Route('/new/addDestination', name: 'app_carpooling_new_destination', methods: ['GET', 'POST'])]
public function addDestination(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
{   
    $carpooling = new Carpooling();
    $form = $this->createForm(AddDestinationType::class, $carpooling);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        
        $session = $request->getSession();
         $this->get('session')->getFlashBag()->set('destination', $carpooling->getDestination());
      
        $departure = $this->get('session')->getFlashBag()->get('departure')[0] ?? null;
        $this->get('session')->getFlashBag()->set('departure', $departure);

        var_dump($departure);
        // Get the value of 'destination' from the form
        $destination = $form->get('destination')->getData();

        // Set 'departure' and 'destination' to the carpooling entity
        $carpooling->setDeparture($departure);
        $carpooling->setDestination($destination);

       /* // Persist data to the database
        $entityManager->persist($carpooling);
        $entityManager->flush(); */

        return $this->redirectToRoute('app_carpooling_new_date');
    }

    return $this->renderForm('carpooling/addDestination.html.twig', [
        'carpooling' => $carpooling,
        'form' => $form,
    ]);
}

#[Route('/new/addDate', name: 'app_carpooling_new_date', methods: ['GET', 'POST'])]
public function adddate(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
{
    $carpooling = new Carpooling();
    $form = $this->createForm(AddDateType::class, $carpooling);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Store the departure data in the session flash bag
        $session = $request->getSession();
        $this->get('session')->getFlashBag()->set('arrivalDate', $carpooling->getArrivalDate());


        $departure = $this->get('session')->getFlashBag()->get('departure')[0] ?? null;
        $this->get('session')->getFlashBag()->set('departure', $departure);

        $destination = $this->get('session')->getFlashBag()->get('destination')[0] ?? null;
        $this->get('session')->getFlashBag()->set('destination', $destination);

        $date = $form->get('arrivalDate')->getData();

        $carpooling->setDeparture($departure);
        $carpooling->setDestination($destination);
        $carpooling->setArrivalDate($date);

        return $this->redirectToRoute('app_carpooling_new_time');
    }

    return $this->renderForm('carpooling/addDate.html.twig', [
        'carpooling' => $carpooling,
        'form' => $form,
    ]);
}

#[Route('/new/addTime', name: 'app_carpooling_new_time', methods: ['GET', 'POST'])]
public function addTime(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): Response
{
    $carpooling = new Carpooling();
    $form = $this->createForm(AddTimeType::class, $carpooling);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Store the departure data in the session flash bag
     /*   $session = $request->getSession();
         $this->get('session')->getFlashBag()->set('date', $carpooling->getArrivalDate());*/
         $session = $request->getSession();
         $this->get('session')->getFlashBag()->set('time', $carpooling->getTime());

        $departure = $this->get('session')->getFlashBag()->get('departure')[0] ?? null;
        $this->get('session')->getFlashBag()->set('departure', $departure);
        var_dump($departure);

        $destination = $this->get('session')->getFlashBag()->get('destination')[0] ?? null;
        var_dump($destination);

        $this->get('session')->getFlashBag()->set('destination', $destination);

        $arrivalDate = $this->get('session')->getFlashBag()->get('arrivalDate')[0] ?? null;
        var_dump($arrivalDate);
$this->get('session')->getFlashBag()->set('arrivalDate', $arrivalDate);

        $time = $form->get('time')->getData();
        var_dump($time);


        $carpooling->setDeparture($departure);
        $carpooling->setDestination($destination);
        $carpooling->setArrivalDate($arrivalDate);
        $carpooling->setTime($time);

     // Persist the carpooling entity to the database
        $entityManager->persist($carpooling);
        $entityManager->flush(); 

        return $this->redirectToRoute('app_home');
    }

    return $this->renderForm('carpooling/addTime.html.twig', [
        'carpooling' => $carpooling,
        'form' => $form,
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
        if ($this->isCsrfTokenValid('delete' . $carpooling->getId(), $request->request->get('_token'))) {
            $entityManager->remove($carpooling);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_carpooling_index', [], Response::HTTP_SEE_OTHER);
    }
}
