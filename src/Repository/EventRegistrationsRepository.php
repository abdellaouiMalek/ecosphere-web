<?php

namespace App\Repository;

use App\Entity\EventRegistrations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventRegistrations>
 *
 * @method EventRegistrations|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRegistrations|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRegistrations[]    findAll()
 * @method EventRegistrations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRegistrationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRegistrations::class);
    }

//    /**
//     * @return EventRegistrations[] Returns an array of EventRegistrations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EventRegistrations
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
