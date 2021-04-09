<?php

namespace App\Repository;

use App\Entity\Injure;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Injure|null find($id, $lockMode = null, $lockVersion = null)
 * @method Injure|null findOneBy(array $criteria, array $orderBy = null)
 * @method Injure[]    findAll()
 * @method Injure[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InjuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Injure::class);
    }

    // /**
    //  * @return Injures[] Returns an array of Injures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Injures
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
