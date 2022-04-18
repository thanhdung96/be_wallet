<?php

namespace App\MainBundle\Repository;

use App\MainBundle\Entity\AccountSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccountSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountSetting[]    findAll()
 * @method AccountSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountSettingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountSetting::class);
    }

    // /**
    //  * @return AccountSetting[] Returns an array of AccountSetting objects
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
    public function findOneBySomeField($value): ?AccountSetting
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
