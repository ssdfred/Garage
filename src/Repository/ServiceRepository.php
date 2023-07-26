<?php


namespace App\Repository;

use App\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    // Ajoutez ici vos méthodes de requête personnalisées pour l'entité Service

    public function findAllServicesOrderedByTitle()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.title', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
