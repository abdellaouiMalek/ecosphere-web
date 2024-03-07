<?php

namespace App\Repository;

use App\Entity\EventRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EventRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventRating::class);
    }

    public function getStarRatingsCount(): array
    {
        $qb = $this->createQueryBuilder('er')
            ->select('er.rating, COUNT(er.id) as count')
            ->groupBy('er.rating')
            ->getQuery();

        $ratings = $qb->getResult();
        $starRatingsCount = [];

        foreach ($ratings as $rating) {
            $starRatingsCount[$rating['rating']] = $rating['count'];
        }

        return $starRatingsCount;
    }
}
