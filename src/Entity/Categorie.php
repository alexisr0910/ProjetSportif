<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: licencie::class)]
    private Collection $categorie;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomCategorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeRaccourcie = null;

    public function __construct()
    {
        $this->categorie_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, licencie>
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(licencie $categorie): static
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie->add($categorie);
            $categorie->setCategorie($this);
        }

        return $this;
    }

    public function removeCategorie(licencie $categorie): static
    {
        if ($this->categorie->removeElement($categorie)) {
            // set the owning side to null (unless already changed)
            if ($categorie->getCategorie() === $this) {
                $categorie->setCategorie(null);
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
        return $this->nomCategorie; // Retournez la propriété appropriée à afficher
    }
}
