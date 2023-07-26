<?php


namespace App\Repository;

use App\Entity\Horaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Horaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Horaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Horaire[]    findAll()
 * @method Horaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Horaire::class);
    }

    public function save(Horaire $horaire, bool $flush = false): void
    {
        $this->_em->persist($horaire);

        if ($flush) {
            $this->_em->flush();
        }
    }
}