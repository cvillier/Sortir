<?php

namespace App\Repository;

use App\Entity\AccessDeniedHandler;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccessDeniedHandler|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccessDeniedHandler|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccessDeniedHandler[]    findAll()
 * @method AccessDeniedHandler[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccessDeniedHandlerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccessDeniedHandler::class);
    }

    // /**
    //  * @return AccessDeniedHandler[] Returns an array of AccessDeniedHandler objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AccessDeniedHandler
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
