<?php

namespace App\Repository;

use App\Entity\EventTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EventTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventTask[]    findAll()
 * @method EventTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventTaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EventTask::class);
    }

    /**
     * @return EventTask[]
     * @param $dateStart
     * @param $dateEnd
     */
    public function searchByDates($dateStart, $dateEnd)
    {
        return $this->createQueryBuilder('e')
            ->where('e.dateDebut >= :debut AND e.dateFin < :fin')
            ->orWhere('e.dateDebut < :fin AND e.dateFin > :fin')
            ->orWhere('e.dateDebut < :debut AND e.dateFin > :debut')
            ->setParameter('debut', $dateStart)
            ->setParameter('fin', $dateEnd)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return EventTask[] Returns an array of EventTask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventTask
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
