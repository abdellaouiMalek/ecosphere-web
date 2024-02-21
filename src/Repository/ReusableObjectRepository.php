<?php

namespace App\Repository;

use App\Entity\ReusableObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReusableObject>
 *
 * @method ReusableObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReusableObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReusableObject[]    findAll()
 * @method ReusableObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReusableObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReusableObject::class);
    }

//    /**
//     * @return ReusableObject[] Returns an array of ReusableObject objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReusableObject
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
