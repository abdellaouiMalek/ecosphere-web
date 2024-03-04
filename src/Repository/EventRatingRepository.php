<?php

namespace App\Repository;

use App\Entity\EventRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EventRating>
 *
 * @method EventRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventRating[]    findAll()
 * @method EventRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRating::class);
    }

//    /**
//     * @return EventRating[] Returns an array of EventRating objects
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

//    public function findOneBySomeField($value): ?EventRating
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
