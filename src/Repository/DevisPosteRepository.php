<?php

namespace App\Repository;

use App\Entity\DevisPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisPoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisPoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisPoste[]    findAll()
 * @method DevisPoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisPosteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisPoste::class);
    }

    // /**
    //  * @return DevisPoste[] Returns an array of DevisPoste objects
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
    public function findOneBySomeField($value): ?DevisPoste
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
