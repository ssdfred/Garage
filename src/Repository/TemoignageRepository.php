<?php


namespace App\Repository;

use App\Entity\Temoignage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TemoignageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Temoignage::class);
    }

    // Ajoutez ici vos méthodes de requête personnalisées pour l'entité Temoignage

    public function findApprovedTemoignages()
    {
        return $this->createQueryBuilder('t')
            ->where('t.approved = true')
            ->getQuery()
            ->getResult();
    }
}
