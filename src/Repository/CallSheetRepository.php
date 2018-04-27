<?php

namespace App\Repository;

use App\Entity\CallSheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CallSheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method CallSheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method CallSheet[]    findAll()
 * @method CallSheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CallSheetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CallSheet::class);
    }

//    /**
//     * @return CallSheet[] Returns an array of CallSheet objects
//     */
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
    public function findOneBySomeField($value): ?CallSheet
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
