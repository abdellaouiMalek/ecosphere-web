<?php

namespace App\Repository;

use App\Entity\CarpoolingRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CarpoolingRequest>
 *
 * @method CarpoolingRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarpoolingRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarpoolingRequest[]    findAll()
 * @method CarpoolingRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarpoolingRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarpoolingRequest::class);
    }

//    /**
//     * @return CarpoolingRequest[] Returns an array of CarpoolingRequest objects
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

//    public function findOneBySomeField($value): ?CarpoolingRequest
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
