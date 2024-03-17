<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findByUser(User $user)
    {
        return $this->createQueryBuilder('e')
            ->andWhere(':user MEMBER OF e.users')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }


public function getPaginatedEvents($page, $limit, $filters = null){
    $query = $this->createQueryBuilder('a');
        

    // On filtre les données
    if($filters != null){
        $query->andWhere('a.category IN(:cats)')
            ->setParameter(':cats', array_values($filters));
    }

    $query->orderBy('a.date')
        ->setFirstResult(($page * $limit) - $limit)
        ->setMaxResults($limit)
    ;
    return $query->getQuery()->getResult();
}

public function getTotalEvents($filters = null){
    $query = $this->createQueryBuilder('a')
        ->select('COUNT(a)');
        
    // On filtre les données
    if($filters != null){
        $query->andWhere('a.category IN(:cats)')
            ->setParameter(':cats', array_values($filters));
    }

    return $query->getQuery()->getSingleScalarResult();
}
}
