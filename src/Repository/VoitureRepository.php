<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\BrowserKit\Response;

/**
 * @extends ServiceEntityRepository<Voiture>
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function save(Voiture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Voiture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   

    public function findVoituresByCriteria($prix, $kilometrage, $anneeMiseCirculation)
    {
        return $this->createQueryBuilder('v')
            ->where('v.prix <= :prix')
            ->where('v.prix >= :prix')
            ->andWhere('v.kilometrage <= :kilometrage')
            ->andWhere('v.anneeMiseCirculation = :anneeMiseCirculation')
            ->setParameters([
                'prix' => $prix,
                'kilometrage' => $kilometrage,
                'anneeMiseCirculation' => $anneeMiseCirculation
            ])
            ->getQuery()
            ->getResult();
    }

    public function findMessagesByVoiture(Voiture $voiture)
    {
        return $this->createQueryBuilder('v')
            ->leftJoin('v.messages', 'm')
            ->andWhere('m.voiture = :voiture')
            ->setParameter('voiture', $voiture)
            ->getQuery()
            ->getResult();
    }

    public function findAllByPrixRange(float $prixMin, float $prixMax): array
    {
        dump($prixMin, $prixMax); // Vérifier les valeurs des paramètres
        $query = $this->createQueryBuilder('v')
            ->where('v.prix >= :prixMin')
            ->andWhere('v.prix <= :prixMax')
            ->setParameter('prixMin', $prixMin)
            ->setParameter('prixMax', $prixMax)
            ->getQuery()
            ->getResult();
        dump($query); // Vérifier les résultats de la requête
        return $query;
    }

 

    public function findMaxPrixByPrixRange(float $prixMin, float $prixMax): array
    {
        // Récupérer toutes les voitures qui se trouvent dans la plage de prix donnée
        dump($prixMin, $prixMax); // Vérifier les valeurs des paramètres
        $results = $this->createQueryBuilder('v')
        ->where('v.prix >= :prixMin')
        ->andWhere('v.prix <= :prixMax')
        ->setParameter('prixMin', $prixMin)
        ->setParameter('prixMax', $prixMax)
        ->getQuery()
        ->getResult();

    dump($results); // Vérifier les résultats de la requête

    return $results;
}

}