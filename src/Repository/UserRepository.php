<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Find if the email and password match
     *
     * @param string $mail
     * @param string $pass
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByNameAndPass(string $mail, string $pass)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email= :mail AND u.password = :pass')
            ->setParameter('mail', $mail)
            ->setParameter('pass', $pass)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $token
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByToken(string $token)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.token = :token')
            ->setParameter('token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
