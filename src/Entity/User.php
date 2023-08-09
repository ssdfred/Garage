<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "user")]
#[UniqueEntity(fields: ["email"], message: "L'email est déjà utilisé")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private $nom;

    #[ORM\Column(type: "string", length: 255)]
    private $prenom;

    #[ORM\Column(type: "string", length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $password;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Voiture::class)]
    #[ORM\JoinColumn(name:'voiture_id', referencedColumnName: 'id')]
    private Collection $voitures;
    
    #[ORM\OneToMany(mappedBy: "user", targetEntity: FormulaireContact::class)]
    private Collection $formulaireContacts;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: Temoignage::class)]
    #[ORM\JoinColumn(name:'temoignage_id', referencedColumnName: 'id')]
    private Collection $temoignages;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: FormulaireContact::class)]
    #[ORM\JoinColumn(name:'formulaireContact_id', referencedColumnName: 'id')]
    private Collection $formulaireContacts;
    
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
        $this->voitures = new ArrayCollection();
        $this->temoignages = new ArrayCollection();
        $this->formulaireContacts = new ArrayCollection();
        
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $this->passwordHasher->hashPassword($this, $password);

        return $this;
    }

 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }
    public function __toString(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
    
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->passwordHasher;
    }

    public function setPasswordHasher(UserPasswordHasherInterface $passwordHasher): self
    {
        $this->passwordHasher = $passwordHasher;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials(): void
    {

    }

    public function getSalt()
    {
        // Inutile car l'algorithme de hachage moderne gère le sel interne
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @return Collection|Voiture[]
     */
    public function getVoitures(): Collection
    {
        return $this->voitures;
    }

    public function addVoiture(Voiture $voiture): self
    {
        if (!$this->voitures->contains($voiture)) {
            $this->voitures[] = $voiture;
            $voiture->setUser($this);
        }

        return $this;
    }

    public function removeVoiture(Voiture $voiture): self
    {
        if ($this->voitures->contains($voiture)) {
            $this->voitures->removeElement($voiture);
            // set the owning side to null (unless already changed)
            if ($voiture->getUser() === $this) {
                $voiture->setUser(null);
            }
        }
    
        return $this;
    }
    public function getTemoignages(): Collection
    {
        return $this->temoignages;
    }
public function addTemoignage(Temoignage $temoignage): self
    {
        if (!$this->temoignages->contains($temoignage)) {
            $this->temoignages[] = $temoignage;
            $temoignage->setUser($this);
        }

        return $this;
    }

    public function removeTemoignage(Temoignage $temoignage): self
    {
        if ($this->temoignages->contains($temoignage)) {
            $this->temoignages->removeElement($temoignage);
            // set the owning side to null (unless already changed)
            if ($temoignage->getUser() === $this) {
                $temoignage->setUser(null);
            }
        }
        return $this;
    }

    /**
     * Get the value of formulaireContacts
     */ 
    public function getFormulaireContacts()
    {
        return $this->formulaireContacts;
    }

    /**
     * Set the value of formulaireContacts
     *
     * @return  self
     */ 
    public function setFormulaireContacts($formulaireContacts)
    {
        $this->formulaireContacts = $formulaireContacts;

        return $this;
    }
}