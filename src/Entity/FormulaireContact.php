<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\ContactRepository;
use App\Entity\Voiture;

#[ORM\Entity(repositoryClass: ContactRepository::class)]

class FormulaireContact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "text")]
    private $Sujet;

    #[ORM\Column(type: "string", length: 255)]
    private $nom;

    #[ORM\Column(type: "string", length: 255)]
    private $prenom;

    #[ORM\Column(type: "string", length: 255)]
    private $email;

    #[ORM\Column(type: "string", length: 255)]
    private $numeroTelephone;

    #[ORM\ManyToOne(targetEntity: Voiture::class, inversedBy: "formulaireContacts")]
    #[ORM\JoinColumn(nullable: true)]
    private $voiture;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "formulaireContacts")]
    private $user;
    
    #[ORM\Column(type: "text")]
    private $message;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumeroTelephone(): ?string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;

        return $this;
    }

    public function getVoiture(): ?Voiture
    {
        return $this->voiture;
    }

    public function setVoiture(Voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getSujet(): ?string
    {
        return $this->Sujet;
    }

    /**
     * @param mixed $Sujet
     */
    public function setSujet(string $Sujet): ?self
    {
        $this->Sujet = $Sujet;

        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }
}
