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

    /**
     * @param int $user
     * @param string $date
     * @return mixed
     */
    public function findLocationByUser(int $user, string $date)
    {
        return $this->createQueryBuilder('c')
            ->join('c.event', 'e')
            ->join('e.location', 'l')
            ->andWhere('c.user = :user AND c.event = e.id AND e.date >= :date AND e.location = l.id')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->orderBy('e.date', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @param string $qrcode
     * @param int $user
     * @param int $beacon
     * @param string $date
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findEventNow(string $qrcode, int $user, int $beacon, string $date)
    {
        return $this->createQueryBuilder('c')
            ->join('c.event', 'e')
            ->join('e.location', 'l')
            ->andWhere('c.user = :user AND c.event = e.id AND e.startDate <= :date AND :date <= e.endDate AND e.location = l.id AND l.qrcode = :qrcode AND l.beacon = :beacon')
            ->setParameter('qrcode', $qrcode)
            ->setParameter('beacon', $beacon)
            ->setParameter('date', $date)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /**
     * @param int $userId
     * @param string $date
     * @return mixed
     */
    public function findByUserAndAbsence(int $userId, string $date, string $limit)
    {
        return $this->createQueryBuilder('c')
        ->join('c.event', 'e')
        ->andWhere('c.user = :user AND c.present = 0 AND c.late = 0 AND e.endDate <= :date AND e.startDate >= :limit')
        ->setParameter('user', $userId)
        ->setParameter('date', $date)
        ->setParameter('limit', $limit)
        ->orderBy('e.id', 'ASC')
        ->getQuery()
        ->getResult()
        ;
    }

    /**
     * @param int $userId
     * @param string $date
     * @return mixed
     */
    public function findByUserAndLate(int $userId, string $date, string $limit)
    {
        return $this->createQueryBuilder('c')
            ->join('c.event', 'e')
            ->andWhere('c.user = :user AND c.present = 0 AND c.late = 1 AND e.endDate <= :date AND e.startDate >= :limit')
            ->setParameter('user', $userId)
            ->setParameter('date', $date)
            ->setParameter('limit', $limit)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param int $userId
     * @param string $date
     * @return mixed
     */
    public function findByUserAndPresent(int $userId, string $date, string $limit)
    {
        return $this->createQueryBuilder('c')
            ->join('c.event', 'e')
            ->andWhere('c.user = :user AND c.present = 1 AND c.late = 0 AND e.endDate <= :date AND e.startDate >= :limit')
            ->setParameter('user', $userId)
            ->setParameter('date', $date)
            ->setParameter('limit', $limit)
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
