<?php

namespace App\Entity;
use App\Entity\FormulaireContact;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoitureRepository::class)]
class Voiture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $titre;

    #[ORM\Column(type: "text")]
    private $description;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private $prix;

    #[ORM\Column(type: "string", length: 255)]
    private $image;

    #[ORM\Column(type: "date")]
    private $anneeMiseCirculation;

    #[ORM\Column(type: "integer")]
    private $kilometrage;

    #[ORM\Column(type: "text")]
    private $galerieImages;

    #[ORM\Column(type: "text")]
    private $caracteristiques;

    #[ORM\Column(type: "text")]
    private $equipementsOptions;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "voitures")]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: "voiture", targetEntity: FormulaireContact::class)]
    private $formulaireContacts;
    

    public function __construct()
    {
        $this->formulaireContacts = new ArrayCollection();
    }

    /**
     * @return Collection|FormulaireContact[]
     */
    public function getFormulaireContacts(): Collection
    {
        return $this->formulaireContacts;
    }

    public function addFormulaireContact(FormulaireContact $formulaireContact): self
    {
        if (!$this->formulaireContacts->contains($formulaireContact)) {
            $this->formulaireContacts[] = $formulaireContact;
            $formulaireContact->setVoiture($this);
        }

        return $this;
    }

    public function removeFormulaireContact(FormulaireContact $formulaireContact): self
    {
        if ($this->formulaireContacts->removeElement($formulaireContact)) {
            // set the owning side to null (unless already changed)
            if ($formulaireContact->getVoiture() === $this) {
                $formulaireContact->setVoiture( $this);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAnneeMiseCirculation(): ?\DateTimeInterface
    {
        return $this->anneeMiseCirculation;
    }

    public function setAnneeMiseCirculation(?\DateTimeInterface $anneeMiseCirculation): self
    {
        $this->anneeMiseCirculation = $anneeMiseCirculation;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(?int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getGalerieImages(): ?string
    {
        return $this->galerieImages;
    }

    public function setGalerieImages(?string $galerieImages): self
    {
        $this->galerieImages = $galerieImages;

        return $this;
    }

    public function getCaracteristiques(): ?string
    {
        return $this->caracteristiques;
    }

    public function setCaracteristiques(?string $caracteristiques): self
    {
        $this->caracteristiques = $caracteristiques;

        return $this;
    }

    public function getEquipementsOptions(): ?string
    {
        return $this->equipementsOptions;
    }

    public function setEquipementsOptions(?string $equipementsOptions): self
    {
        $this->equipementsOptions = $equipementsOptions;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
