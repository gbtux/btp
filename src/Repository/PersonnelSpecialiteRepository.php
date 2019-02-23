<?php

namespace App\Repository;

use App\Entity\PersonnelSpecialite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PersonnelSpecialite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonnelSpecialite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonnelSpecialite[]    findAll()
 * @method PersonnelSpecialite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonnelSpecialiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PersonnelSpecialite::class);
    }

    // /**
    //  * @return PersonnelSpecialite[] Returns an array of PersonnelSpecialite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonnelSpecialite
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
