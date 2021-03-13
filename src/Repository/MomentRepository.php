<?php

namespace App\Repository;

use App\Entity\Moment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Moment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Moment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Moment[]    findAll()
 * @method Moment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MomentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Moment::class);
    }

    // /**
    //  * @return Moment[] Returns an array of Moment objects
    //  */
    public function FilterDate($moments)
    {
        $date = new \DateTime();
        return $this->createQueryBuilder('m')
            ->andWhere('m.date >= :date')
            ->setParameter('date', $date)
            ->orderBy('m.date', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getCurrentLesson($category, $date)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.Category = :c')
            ->andWhere('m.date = :date')
            ->setParameter('c', $category)
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
            ;
    }
}
