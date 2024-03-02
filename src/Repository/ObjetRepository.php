<?php

namespace App\Repository;

use App\Entity\Objet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Objet>
 *
 * @method Objet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Objet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Objet[]    findAll()
 * @method Objet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Objet::class);
    }

    public function save(Objet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Objet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Objet[] Returns an array of Objet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Objet
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


public function index(SessionInterface $session, ObjetRepository $objetRepository): Response
{
    $panier = $session->get('panier', []);
    $panierWithData = [];
    foreach ($panier as $id => $quantity) {
        $objet = $objetRepository->find($id);
        if ($objet) {
            $panierWithData[] = [
                'objet' => $objet,
                'quantity' => $quantity
            ];
        } else {
            // Si l'objet n'existe pas, le retirer du panier
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
}
