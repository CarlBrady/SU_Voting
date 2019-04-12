<?php

namespace App\Repository;

use App\Entity\Down;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Down|null find($id, $lockMode = null, $lockVersion = null)
 * @method Down|null findOneBy(array $criteria, array $orderBy = null)
 * @method Down[]    findAll()
 * @method Down[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DownRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Down::class);
    }

    // /**
    //  * @return Down[] Returns an array of Down objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Down
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
