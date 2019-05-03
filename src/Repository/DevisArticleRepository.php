<?php

namespace App\Repository;

use App\Entity\DevisArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method DevisArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method DevisArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method DevisArticle[]    findAll()
 * @method DevisArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DevisArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, DevisArticle::class);
    }

    public function searchByReference($search)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.reference LIKE :val')
            ->setParameter('val', '%' . $search . '%')
            ->getQuery()
            ->getResult();
    }

    /*public function findByEstimation($estimation)
    {
        return $this->createQueryBuilder('d')
            ->join('d.sousPoste','sp')
            ->where('d.sousPoste = sp');
    }

    // /**
    //  * @return DevisArticle[] Returns an array of DevisArticle objects
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
    public function findOneBySomeField($value): ?DevisArticle
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
