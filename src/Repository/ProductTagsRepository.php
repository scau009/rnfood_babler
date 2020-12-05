<?php

namespace App\Repository;

use App\Entity\ProductTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductTags|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTags|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTags[]    findAll()
 * @method ProductTags[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTags::class);
    }

    public function findByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('p');
        return $qb->where($qb->expr()->in('p.id',$ids))->getQuery()->getResult();
    }
    // /**
    //  * @return ProductTags[] Returns an array of ProductTags objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductTags
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
