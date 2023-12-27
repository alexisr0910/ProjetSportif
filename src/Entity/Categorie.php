<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_categorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomCategorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeRaccourcie = null;

    #[ORM\OneToMany(mappedBy: 'nomCategorie', targetEntity: Licencie::class)]
    private Collection $accessLicencie;

    public function __construct()
    {
        $this->accessLicencie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategorie(): ?string
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?string $id_categorie): static
    {
        $this->id_categorie = $id_categorie;

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

    /**
     * @return Collection<int, Licencie>
     */
    public function getAccessLicencie(): Collection
    {
        return $this->accessLicencie;
    }

    public function addAccessLicencie(Licencie $accessLicencie): static
    {
        if (!$this->accessLicencie->contains($accessLicencie)) {
            $this->accessLicencie->add($accessLicencie);
            $accessLicencie->setNomCategorie($this);
        }

        return $this;
    }

    public function removeAccessLicencie(Licencie $accessLicencie): static
    {
        if ($this->accessLicencie->removeElement($accessLicencie)) {
            // set the owning side to null (unless already changed)
            if ($accessLicencie->getNomCategorie() === $this) {
                $accessLicencie->setNomCategorie(null);
            }
        }

        return $this;
    }
}
