<?php

namespace App\Controller;

use App\Form\EventFormType;
use App\Entity\Event;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;

class EventsController extends AbstractController
{

    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/events', name: 'app_events')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();
        return $this->render('events/eventsHomePage.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/add-event', name: 'app_add_event')]
    public function addEvent(Request $request): Response
    {
        // Create a new Event entity
        $event = new Event();

        // Handle form submission
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Save the event to the database
            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            // Redirect to the home page or display a success message
            return $this->redirectToRoute('app_events');
        }

        // Render the add event form template with the form
        return $this->render('events/addevent.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/event/{id}', name: 'more_details')]
    public function moreDetails($id): Response
    {
         $event = $this->managerRegistry->getRepository(Event::class)->find($id);
         return $this->render('events/eventDetails.html.twig', [
            'event' => $event,
         ]);
    }

    #[Route('/delete-event/{id}', name: 'app_delete_event')]
    public function deleteEvent($id): Response
    {
    $entityManager = $this->managerRegistry->getManager();
    $event = $entityManager->getRepository(Event::class)->find($id);
    $entityManager->remove($event);
    $entityManager->flush();
    return $this->redirectToRoute('app_events');
    }

    
    #[Route('/update-event/{id}', name: 'app_update_event')]
    public function updateEvent(Request $request, $id): Response
    {
    $entityManager = $this->managerRegistry->getManager();
    $event = $entityManager->getRepository(Event::class)->find($id);

    // Create the update form and populate it with event's current information
    $form = $this->createForm(EventFormType::class, $event);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();
        return $this->redirectToRoute('app_events');
    }
    return $this->render('events/update_event.html.twig', [
        'form' => $form->createView(),
        'formTitle' => 'Update Event',
    ]);
    }

}
