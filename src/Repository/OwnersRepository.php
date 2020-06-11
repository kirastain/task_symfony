<?php

namespace App\Repository;

use App\Entity\Owners;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Owners|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owners|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owners[]    findAll()
 * @method Owners[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owners::class);
    }

    // /**
    //  * @return Owners[] Returns an array of Owners objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Owners
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
