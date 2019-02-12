<?php

namespace App\Repository;

use App\Entity\FamilleArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FamilleArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method FamilleArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method FamilleArticle[]    findAll()
 * @method FamilleArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FamilleArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FamilleArticle::class);
    }

    // /**
    //  * @return FamilleArticle[] Returns an array of FamilleArticle objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FamilleArticle
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
