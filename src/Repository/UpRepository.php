<?php

namespace App\Repository;

use App\Entity\Up;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Up|null find($id, $lockMode = null, $lockVersion = null)
 * @method Up|null findOneBy(array $criteria, array $orderBy = null)
 * @method Up[]    findAll()
 * @method Up[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UpRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Up::class);
    }

    // /**
    //  * @return Up[] Returns an array of Up objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Up
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
