<?php

namespace App\Repository;

use App\Entity\DevisSousPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisSousPoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisSousPoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisSousPoste[]    findAll()
 * @method DevisSousPoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisSousPosteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisSousPoste::class);
    }

    // /**
    //  * @return DevisSousPoste[] Returns an array of DevisSousPoste objects
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
    public function findOneBySomeField($value): ?DevisSousPoste
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
