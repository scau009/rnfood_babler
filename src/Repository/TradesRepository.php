<?php

namespace App\Repository;

use App\Entity\Trades;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trades|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trades|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trades[]    findAll()
 * @method Trades[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TradesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trades::class);
    }

    public function findAllBySort(array $orderBy)
    {
        $q = $this->createQueryBuilder('t');
        foreach ($orderBy as $key => $value) {
            $q->orderBy('t.' . $key, $value);
        }
        return $q->getQuery();
    }

    public function findOneByTid(string $tid)
    {
        return $this->createQueryBuilder('t')->andWhere('t.tid = :tid')->setParameter('tid', $tid)->getQuery()->getOneOrNullResult();
    }

    public function findOneById(string $id)
    {
        return $this->find($id);
    }

    public function findAllByClientId(string $clientId,string  $status = '')
    {
        if ($status) {
            return $this->createQueryBuilder('t')
                ->andWhere('t.buyer.id = :clientId')
                ->setParameter('clientId', $clientId)
                ->andWhere('t.status = :status')
                ->setParameter('status', $status)
                ->getQuery();
        }else{
            return $this->createQueryBuilder('t')->andWhere('t.buyer.id = :clientId')->setParameter('clientId', $clientId)->getQuery();
        }

    }

    // /**
    //  * @return Trades[] Returns an array of Trades objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trades
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
