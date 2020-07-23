<?php

namespace App\Repository;

use App\Security\AccessDeniedHandler;
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

}
