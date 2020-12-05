<?php

namespace App\Repository;

use App\Entity\StoreAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoreAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoreAddress[]    findAll()
 * @method StoreAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreAddress::class);
    }

    // /**
    //  * @return StoreAddress[] Returns an array of StoreAddress objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StoreAddress
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
