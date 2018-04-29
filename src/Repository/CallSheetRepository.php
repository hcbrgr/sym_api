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
    /**
     * CallSheetRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CallSheet::class);
    }

    /**
     * Find the location by user's id and date
     * @param int $user
     * @param string $date
     * @return mixed
     */
    public function findLocationByUser(int $user, string $date): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.event', 'e')
            ->join('e.location', 'l')
            ->andWhere('c.user = :user AND c.event = e.id AND e.startDate >= :date')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->orderBy('e.startDate', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Find the current event by user's id, beacon location of the current user, date and QRcode
     *
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
     * Find absence by user id and current date
     *
     * @param int $userId
     * @param string $date
     * @return mixed
     */
    public function findAbsenceByUser(int $userId, string $date, string $limit)
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
     * Find delay by user id and current date
     *
     * @param int $userId
     * @param string $date
     * @return mixed
     */
    public function findDelayByUser(int $userId, string $date, string $limit)
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
     * Find presence by user id and current date
     *
     * @param int $userId
     * @param string $date
     * @return mixed
     */
    public function findPresenceByUser(int $userId, string $date, string $limit)
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
