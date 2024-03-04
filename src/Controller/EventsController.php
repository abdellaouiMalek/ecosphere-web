<?php

namespace App\Controller;

use App\Form\EventFormType;
use App\Entity\Event;
use App\Entity\Category;
use App\Entity\EventRating;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\EventRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class EventsController extends AbstractController
{

    private $managerRegistry; // Define a private property for the managerRegistry
    private $logger; // Define a private property for the logger

    // Inject both dependencies via the constructor
    public function __construct(ManagerRegistry $managerRegistry, LoggerInterface $logger)
    {
        $this->managerRegistry = $managerRegistry;
        $this->logger = $logger;
    }

    #[Route('/events', name: 'app_events')]
    public function index(EventRepository $eventRepository, CategoryRepository $categoryRepository, PaginatorInterface $paginatorInterface, Request $request): Response
    {
        $events = $eventRepository->findAll();
        $category = $categoryRepository->findAll();
        $events = $paginatorInterface->paginate($events, $request->query->getInt('page',1),8);

        return $this->render('events/eventsHomePage.html.twig', [
            'events' => $events, 'category' => $category,
        ]);
    }

    #[Route('/add-event', name: 'app_add_event')]
    public function addEvent(Request $request, SluggerInterface $slugger): Response
    {
        // Create a new Event entity
        $event = new Event();

        // Handle form submission
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           /** @var UploadedFile $picture */
           $picture = $form->get('picture')->getData();

           // this condition is needed because the 'brochure' field is not required
           // so the PDF file must be processed only when a file is uploaded
           if ($picture) {
               $originalFilename = pathinfo($picture->getClientOriginalName(), PATHINFO_FILENAME);
               // this is needed to safely include the file name as part of the URL
               $safeFilename = $slugger->slug($originalFilename);
               $newFilename = $safeFilename.'-'.uniqid().'.'.$picture->guessExtension();

               // Move the file to the directory where brochures are stored
               try {
                   $picture->move(
                       $this->getParameter('images_directory'),
                       $newFilename
                   );
               } catch (FileException $e) {
                   // ... handle exception if something happens during file upload
               }

               // updates the 'picturename' property to store the PDF file name
               // instead of its contents
               $event->setImage($newFilename);
           }

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

    #[Route('/save-rating/{id}', name: 'save_rating', methods: ["POST"])]
    public function saveRating(Request $request, EntityManagerInterface $entityManager, $id): JsonResponse
    {
        // Retrieve the rating value and event ID from the request
        $ratingValue = $request->request->get('rate');
        
       // $eventId = $request->request->get('event_id');
    
        // Find the event by its ID
        $event = $entityManager->getRepository(Event::class)->find($id);
        // Create a new EventRating entity and associate it with the event
        $eventRating = new EventRating();
        $eventRating->setRating($ratingValue);
        $eventRating->setEvent($event);
    
        // Persist the EventRating entity
        $entityManager->persist($eventRating);
        $entityManager->flush();
    
        // Return a JSON response indicating success
        return new JsonResponse(['success' => true]);
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
