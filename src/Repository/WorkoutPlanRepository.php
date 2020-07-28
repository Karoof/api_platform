<?php

namespace App\Repository;

use App\Entity\WorkoutPlan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorkoutPlan|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkoutPlan|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkoutPlan[]    findAll()
 * @method WorkoutPlan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutPlanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorkoutPlan::class);
    }

    // /**
    //  * @return WorkoutPlan[] Returns an array of WorkoutPlan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkoutPlan
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
