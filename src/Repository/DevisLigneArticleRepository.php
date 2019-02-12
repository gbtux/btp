<?php

namespace App\Repository;

use App\Entity\DevisLigneArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisLigneArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisLigneArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisLigneArticle[]    findAll()
 * @method DevisLigneArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisLigneArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisLigneArticle::class);
    }

    // /**
    //  * @return DevisLigneArticle[] Returns an array of DevisLigneArticle objects
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
    public function findOneBySomeField($value): ?DevisLigneArticle
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
