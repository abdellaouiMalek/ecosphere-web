<?php

namespace App\Repository;

use App\Entity\Carpooling;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Carpooling>
 *
 * @method Carpooling|null find($id, $lockMode = null, $lockVersion = null)
 * @method Carpooling|null findOneBy(array $criteria, array $orderBy = null)
 * @method Carpooling[]    findAll()
 * @method Carpooling[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarpoolingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Carpooling::class);
    }
    public function rechercherCovoiturages($criteria)
    {
        // Ajoutez des instructions dump() pour déboguer les critères de recherche
        echo "Critères de recherche : --------------------------------------";
        var_dump($criteria);
        // Effectuez la logique de recherche
        $queryBuilder = $this->createQueryBuilder('c');
        
        // Exemple : recherche par destination
        if (!empty($criteria['destination'])) {
            $queryBuilder->andWhere('c.destination = :destination')
                         ->setParameter('destination', $criteria['destination']);
        }

        // Exécutez la requête
        $results = $queryBuilder->getQuery()->getResult();

        // Ajoutez des instructions dump() pour déboguer les résultats de la requête
        echo "Résultats de la requête : ";
        var_dump($results);
        // Retournez les résultats
        return $results;
    }


//    /**
//     * @return Carpooling[] Returns an array of Carpooling objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Carpooling
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}