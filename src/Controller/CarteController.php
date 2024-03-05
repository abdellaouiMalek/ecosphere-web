<?php

namespace App\Controller;

use App\Repository\ObjetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;


class CarteController extends AbstractController
{
    
    #[Route('/carte', name: 'app_carte')]
    public function index(SessionInterface $session, ObjetRepository $objetrespository): Response
    {
        $panier = $session->get('panier', []);
        $panierWithData = [];
        foreach ($panier as $id => $quantity) {
            $objet = $objetrespository->find($id);
            if ($objet) {
                $panierWithData[] = [
                    'objet' => $objet,
                    'quantity' => $quantity
                ];
            } else {
                // Si le produit n'existe pas, le retirer du panier
                unset($panier[$id]);
                $session->set('panier', $panier);
            }
        }

        $total = 0;
        foreach ($panierWithData as $item) {
            $totalItem = $item['objet']->getPrix() * $item['quantity'];
            $total += $totalItem;

        }

        return $this->render('carte/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }


    #[Route('/panier/add/{id}', name: 'cart_add')]
    public function add($id, SessionInterface $session)
    {

      $panier=$session->get('panier',[]);
      if (!!isset($panier[$id])) {
        $panier[$id] = 1;
       } else {
        $panier[$id] = 1;
    }
   
    $session->set('panier', $panier);
        return $this->redirectToRoute('app_carte');
    }

    #[Route('/panier/supprimer/{id}', name: 'cart_remove')]
    public function supprimer($id, SessionInterface $session)
    {
        $panier = $session->get('panier', []);
        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }
        $session->set('panier', $panier);
        return $this->redirectToRoute("app_carte");
    }

    #[Route('/panier/update/{id}/{change}', name: 'cart_update_quantity')]
    public function modifierQuantite($id, $changement, SessionInterface $session): JsonResponse
    {
        $panier = $session->get('panier', []);
        if (isset($panier[$id])) {
            $panier[$id] += $change;
            if ($panier[$id] <= 0) {
                unset($panier[$id]); // Supprimer l'objet si la quantité devient <= 0
            }
            $session->set('panier', $panier);
            return new JsonResponse(['success' => true]);
        }
        return new JsonResponse(['success' => false]);
    }

    #[Route('/process_payment', name: 'process_payment', methods: ["POST"])]
    public function processPayment(SessionInterface $session): RedirectResponse
    {
        // Ici, vous simulez le processus de paiement. Dans un cas réel, vous intégreriez avec une API de paiement.
        // Pour la simulation, vous pouvez juste nettoyer le panier et rediriger vers une page de succès.

        $session->set('panier', []); // Nettoyer le panier après "paiement"
        $this->addFlash('success', 'Votre paiement a été traité avec succès !'); // Ajouter un message de succès

        return $this->redirectToRoute('app_carte'); // Rediriger vers la page d'accueil ou une page de confirmation
    }


    #[Route('/payment', name: 'payment_form')]
    public function paymentForm(): Response
    {

        $this->addFlash('success', 'Paiement traité avec succès !');
        return $this->render('Carte/form.html.twig');
    }

}
