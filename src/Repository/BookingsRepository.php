<?php

namespace App\Repository;

use App\Entity\Bookings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bookings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookings[]    findAll()
 * @method Bookings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookings::class);
    }


    public function findAllBookingsByActivity($id)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.deleted_at is NULL')
            ->andWhere('b.activity = :id')
            ->setParameter('id', $id)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findAllBookingById($id)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }
    public function findAllBookingsByUser($id){
        return $this->createQueryBuilder('b')
            ->andWhere('b.deleted_at is NULL')
            ->andWhere('b.booked_by = :id')
            ->setParameter('id', $id)
            ->orderBy('b.started_at', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Bookings[] Returns an array of Bookings objects
    //  */
    /*


    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bookings
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
