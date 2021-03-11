<?php

namespace App\Repository;

use App\Entity\SoortActiviteiten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SoortActiviteiten|null find($id, $lockMode = null, $lockVersion = null)
 * @method SoortActiviteiten|null findOneBy(array $criteria, array $orderBy = null)
 * @method SoortActiviteiten[]    findAll()
 * @method SoortActiviteiten[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SoortActiviteitenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SoortActiviteiten::class);
    }

    // /**
    //  * @return SoortActiviteiten[] Returns an array of SoortActiviteiten objects
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
    public function findOneBySomeField($value): ?SoortActiviteiten
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
