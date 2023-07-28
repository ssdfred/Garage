<?php

namespace App\Repository;

use App\Entity\FormulaireContact;
use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormulaireContact|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormulaireContact|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormulaireContact[]    findAll()
 * @method FormulaireContact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormulaireContact::class);
    }

    public function findMessagesByVoiture(Voiture $voiture)
    {
        return $this->createQueryBuilder('m')
            ->where('m.voiture = :voiture')
            ->setParameter('voiture', $voiture)
            ->getQuery()
            ->getResult();
    }
    public function save(FormulaireContact $formulaireContact)
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($formulaireContact);
        $entityManager->flush();
    }

}
