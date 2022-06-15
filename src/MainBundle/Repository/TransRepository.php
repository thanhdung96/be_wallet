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

    public function findByMonthAndYear(array $params) {
        if (!isset($params['month'])) {
            $month = (int) date('m');
        }
        if (!isset($params['year'])) {
            $year = (int) date('Y');
        }
        $startDate = new \DateTimeImmutable("$year-$month-01T00:00:00");
        $endDate = $startDate->modify('last day of this month')->setTime(23, 59, 59);
    
        $qb = $this->createQueryBuilder('trans');

        $qb->andWhere('trans.account = :account');
        $qb->setParameter('account', $params['account']->getId());

        if(isset($params['types'])){
            $qb->andWhere(
                'trans.type in ('
                .implode(',', $params['types'])
                .')'
            );
        }

        $qb->andWhere('trans.dateTime BETWEEN :start AND :end');
        $qb->setParameter('start', $startDate);
        $qb->setParameter('end', $endDate);
    
        return $qb->getQuery()->getResult();
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
