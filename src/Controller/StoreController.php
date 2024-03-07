<?php

namespace App\Controller;

use App\Entity\Store;
use App\Form\StoreType;
use App\Repository\StoreRepository;
use chillerlan\QRCode\{QRCode, QROptions};
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Request, Response};
use Symfony\Component\Routing\Annotation\Route;


#[Route('/store')]
class StoreController extends AbstractController
{
    #[Route('/', name: 'app_store_index', methods: ['GET'])]
    public function index(StoreRepository $storeRepository): Response
    {
        return $this->render('store/index.html.twig', [
            'stores' => $storeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_store_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $store = new Store();
        $form = $this->createForm(StoreType::class, $store);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $file = $form->get('photo')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_img'), $fileName);

            // Set the uploaded file name to the store entity
            $store->setPhoto($fileName);

            // Construct the URL of the uploaded image
            $imageUrl = $request->getSchemeAndHttpHost() . '/uploads/images/' . $fileName;

            // Generate QR code
            $qrCodeName = $this->generateQRCode($store);

            // Persist and flush the store entity
            $entityManager->persist($store);
            $entityManager->flush();

            // Redirect to the index page
            return $this->redirectToRoute('app_store_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('store/new.html.twig', [
            'store' => $store,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_store_show', methods: ['GET'])]
    public function show(Store $store): Response
    {
        return $this->render('store/show.html.twig', [
            'store' => $store,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_store_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Store $store, EntityManagerInterface $entityManager): Response
    {
        // Your edit action code here
    }

    #[Route('/{id}', name: 'app_store_delete', methods: ['POST'])]
    public function delete(Request $request, Store $store, EntityManagerInterface $entityManager): Response
    {
        // Your delete action code here
    }

    private function generateQRCode(Store $store): string
    {
        $cinemaAddress = str_replace(' ', '+', $store->getAddress());
        $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($cinemaAddress);

        $options = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
            'scale'      => 4,
        ]);

        $qrCode = new QRCode($options);

        // Save the QR code to a file
        $qrCodeName = $store->getStoreName() . '_' . date('YmdHis') . '.png';
        $qrCode->render($googleMapsUrl, '../public/uploads/images/' . $qrCodeName);

        return $qrCodeName;
    }
}
