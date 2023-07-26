<?php
// src/Entity/Horaire.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $jourSemaine;

    #[ORM\Column(type: "time")]
    private $heureOuverture;

    #[ORM\Column(type: "time")]
    private $heureFermeture;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getJourSemaine()
    {
        return $this->jourSemaine;
    }

    /**
     * @param mixed $jourSemaine
     */
    public function setJourSemaine($jourSemaine): void
    {
        $this->jourSemaine = $jourSemaine;
    }

    /**
     * @return mixed
     */
    public function getHeureOuverture()
    {
        return $this->heureOuverture;
    }

    /**
     * @param mixed $heureOuverture
     */
    public function setHeureOuverture($heureOuverture): void
    {
        $this->heureOuverture = $heureOuverture;
    }

    /**
     * @return mixed
     */
    public function getHeureFermeture()
    {
        return $this->heureFermeture;
    }

    /**
     * @param mixed $heureFermeture
     */
    public function setHeureFermeture($heureFermeture): void
    {
        $this->heureFermeture = $heureFermeture;
    }


}
