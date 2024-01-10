<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[UniqueEntity('nomCategorie')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Licencie::class)]
    private Collection $licencies; 

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $nomCategorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $codeRaccourcie = null;

    #[ORM\ManyToMany(targetEntity: MailContact::class, mappedBy: 'destinataires')]
    private Collection $mailContacts;

    public function __construct()
    {
        $this->licencies = new ArrayCollection();
        $this->mailContacts = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Licencie[]
     */
    public function getLicencies(): Collection
    {
        return $this->licencies;
    }

    public function addLicencie(Licencie $licencie): self
    {
        if (!$this->licencies->contains($licencie)) {
            $this->licencies[] = $licencie;
            $licencie->setCategorie($this);
        }

        return $this;
    }

    public function removeLicencie(Licencie $licencie): self
    {
        if ($this->licencies->removeElement($licencie)) {
            if ($licencie->getCategorie() === $this) {
                $licencie->setCategorie(null);
            }
        }

        return $this;
    }

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(?string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    public function getCodeRaccourcie(): ?string
    {
        return $this->codeRaccourcie;
    }

    public function setCodeRaccourcie(?string $codeRaccourcie): static
    {
        $this->codeRaccourcie = $codeRaccourcie;

        return $this;
    }

    public function __toString()
    {
        return $this->nomCategorie;
    }

    /**
     * @return Collection<int, MailContact>
     */
    public function getMailContacts(): Collection
    {
        return $this->mailContacts;
    }

    public function addMailContact(MailContact $mailContact): static
    {
        if (!$this->mailContacts->contains($mailContact)) {
            $this->mailContacts->add($mailContact);
            $mailContact->addDestinataire($this);
        }

        return $this;
    }

    public function removeMailContact(MailContact $mailContact): static
    {
        if ($this->mailContacts->removeElement($mailContact)) {
            $mailContact->removeDestinataire($this);
        }

        return $this;
    }
}
