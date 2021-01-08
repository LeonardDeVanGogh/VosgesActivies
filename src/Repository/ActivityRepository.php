<?php

namespace App\Repository;

use App\Entity\Activity;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Doctrine\ORM\Query\Expr\Join;

/**
 * @method Activity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Activity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Activity[]    findAll()
 * @method Activity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Activity::class);
    }

    public function findAllActivities()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.deleted_at is NULL')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findAllActivitiesJson()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.deleted_at is NULL')
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findActivitiesByUser($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.user = :val')
            ->andWhere('a.deleted_at is NULL')
            ->setParameter('val', $value)
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Activity[] Returns an array of Activity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Activity
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
