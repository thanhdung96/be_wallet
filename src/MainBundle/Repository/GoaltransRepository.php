<?php

namespace App\MainBundle\Repository;

use App\MainBundle\Entity\Goaltrans;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Goaltrans|null find($id, $lockMode = null, $lockVersion = null)
 * @method Goaltrans|null findOneBy(array $criteria, array $orderBy = null)
 * @method Goaltrans[]    findAll()
 * @method Goaltrans[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoaltransRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Goaltrans::class);
    }

    // /**
    //  * @return Goaltrans[] Returns an array of Goaltrans objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Goaltrans
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
