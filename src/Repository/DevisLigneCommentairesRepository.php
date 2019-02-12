<?php

namespace App\Repository;

use App\Entity\DevisLigneCommentaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisLigneCommentaires|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisLigneCommentaires|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisLigneCommentaires[]    findAll()
 * @method DevisLigneCommentaires[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisLigneCommentairesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisLigneCommentaires::class);
    }

    // /**
    //  * @return DevisLigneCommentaires[] Returns an array of DevisLigneCommentaires objects
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
    public function findOneBySomeField($value): ?DevisLigneCommentaires
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
