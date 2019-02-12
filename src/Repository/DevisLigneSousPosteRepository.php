<?php

namespace App\Repository;

use App\Entity\DevisLigneSousPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisLigneSousPoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisLigneSousPoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisLigneSousPoste[]    findAll()
 * @method DevisLigneSousPoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisLigneSousPosteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisLigneSousPoste::class);
    }

    // /**
    //  * @return DevisLigneSousPoste[] Returns an array of DevisLigneSousPoste objects
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
    public function findOneBySomeField($value): ?DevisLigneSousPoste
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
