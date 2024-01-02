<?php

namespace App\Entity;

use App\Repository\LicencieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: LicencieRepository::class)]
#[UniqueEntity('numLicence')]
class Licencie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    #[ORM\Column(nullable: true)]
    private ?int $numLicence = null;

    #[ORM\OneToMany(mappedBy: 'contact', targetEntity: Contact::class, cascade: ['persist', 'remove'])]
    private Collection $contacts;

    #[ORM\OneToOne(mappedBy: 'educateur', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Educateur $educateur = null;

    #[ORM\ManyToOne(inversedBy: 'categorie')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Categorie $categorie = null;


    public function __construct()
    {
        $this->contact = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNumLicence(): ?int
    {
        return $this->numLicence;
    }

    public function setNumLicence(?int $numLicence): static
    {
        $this->numLicence = $numLicence;

        return $this;
    }

    public function getContacts(): Collection
    {
        return $this->contacts;
    }
    
    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setContact($this);
        }
    
        return $this;
    }
    
    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getContact() === $this) {
                $contact->setContact(null);
            }
        }
    
        return $this;
    }

    public function getEducateur(): ?Educateur
    {
        return $this->educateur;
    }

    public function setEducateur(?Educateur $educateur): static
    {
        if ($educateur === null && $this->educateur !== null) {
            $this->educateur->setEducateur(null);
        }

        if ($educateur !== null && $educateur->getEducateur() !== $this) {
            $educateur->setEducateur($this);
        }

        $this->educateur = $educateur;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
}
