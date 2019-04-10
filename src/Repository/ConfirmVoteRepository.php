<?php

namespace App\Repository;

use App\Entity\ConfirmVote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ConfirmVote|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConfirmVote|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConfirmVote[]    findAll()
 * @method ConfirmVote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConfirmVoteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ConfirmVote::class);
    }

    // /**
    //  * @return ConfirmVote[] Returns an array of ConfirmVote objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ConfirmVote
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
