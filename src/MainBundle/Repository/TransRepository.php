<?php

namespace App\MainBundle\Repository;

use App\MainBundle\Entity\Trans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trans|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trans|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trans[]    findAll()
 * @method Trans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trans::class);
    }

    // /**
    //  * @return Trans[] Returns an array of Trans objects
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
    public function findOneBySomeField($value): ?Trans
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
