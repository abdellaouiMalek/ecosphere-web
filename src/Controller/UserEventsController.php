<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;
use Symfony\Component\Security\Core\Security;
use App\Repository\UserRepository;
use App\Entity\User;
use App\Repository\EventRegistrationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\EventRegistrations;
use App\Entity\Event;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;






class UserEventsController extends AbstractController
{

    private $managerRegistry; // Define a private property for the managerRegistry

    // Inject both dependencies via the constructor
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/user/events', name: 'app_user_events', methods: ['GET'])]
    public function index(EventRepository $eventRepository, Security $security): Response
    {
        $user = $security->getUser();
        
        if (!$user) {
            // Handle case when user is not authenticated
            // For example, redirect to login page
            return $this->redirectToRoute('app_login');
        }

        // Retrieve events associated with the current user
        $events = $eventRepository->findByUser($user);

        return $this->render('user_events/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/register-interest', name: 'register_interest', methods: ['POST'])]
    public function registerInterest(Request $request, Security $security, MailerInterface $mailer, UserRepository $UserRepository): JsonResponse
    {
        // Get the event ID from the request body
        $data = json_decode($request->getContent(), true);
        $eventId = $data['eventId'];

        // Get the user ID of the currently logged-in user
        $user = $security->getUser();

        // Get the Event entity corresponding to the provided event ID
        $entityManager = $this->managerRegistry->getManager();
        $event = $entityManager->getRepository(Event::class)->find($eventId);

        if (!$event) {
            // Handle case when the event with the provided ID is not found
            return new JsonResponse(['error' => 'Event not found'], 404);
        }

        // Create a new instance of EventRegistrations
        $registration = new EventRegistrations();
        $registration->setEvent($event); // Set the Event entity
        $registration->setUser($user);
        $registration->setRegistrationDate(new \DateTime());
        $registration->setRegistrationTime(new \DateTime());
        $registration->setStatus('intrested');



        // Persist the registration to the database
        $entityManager->persist($registration);
        $entityManager->flush();
        
        $user = $security->getUser();
        $email = $user->getUserIdentifier();

        $email = (new Email())
       ->from('wardiaziz2507@gmail.com')
       ->to($email)
       ->subject('Time for Symfony Mailer!')
       ->html($this->renderView(
        'email/email.html.twig',
        [
            
            'event' => [
                'eventName' => $event->getEventName(),
                'address' => $event->getAddress(),
                'date' => $event->getDate(),
                'time' => $event->getTime(),
                'location' => $event->getLocation(),
                'objective' => $event->getObjective(),
                'description' => $event->getDescription(),
            ]
        ]
    ));

        $mailer->send($email);


        // Return a JSON response indicating success
        return new JsonResponse(['success' => true]);
    }

    #[Route('/Myevents', name: 'app_Myevents', methods: ['GET'])]
    public function Myevents(EventRepository $eventRepository, Security $security, EventRegistrationsRepository $EventRegistrationsRepository): Response
    {
        $user = $security->getUser();
        
        if (!$user) {
            // Handle case when user is not authenticated
            // For example, redirect to login page
            return $this->redirectToRoute('app_login');
        }

        // Retrieve events associated with the current user
        $Myevents = $EventRegistrationsRepository->findByUser($user);

        return $this->render('user_events/Myevents.html.twig', [
            'Myevents' => $Myevents,
        ]);
    }


}


