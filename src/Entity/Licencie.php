<?php

namespace App\Entity;

use App\Repository\LicencieRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LicencieRepository::class)]
class Licencie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_licencie = null;

    #[ORM\OneToOne(inversedBy: 'accessLicencie', cascade: ['persist', 'remove'])]
    private ?contact $id_contact = null;

    #[ORM\OneToOne(inversedBy: 'accessLicencie', cascade: ['persist', 'remove'])]
    private ?educateur $id_educateur = null;

    #[ORM\ManyToOne(inversedBy: 'accessLicencie')]
    private ?categorie $nomCategorie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomLicencie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenomLicencie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $categorie = null;

  

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLicencie(): ?string
    {
        return $this->id_licencie;
    }

    public function setIdLicencie(?string $id_licencie): static
    {
        $this->id_licencie = $id_licencie;

        return $this;
    }

    public function getIdContact(): ?contact
    {
        return $this->id_contact;
    }

    public function setIdContact(?contact $id_contact): static
    {
        $this->id_contact = $id_contact;

        return $this;
    }

    public function getIdEducateur(): ?educateur
    {
        return $this->id_educateur;
    }

    public function setIdEducateur(?educateur $id_educateur): static
    {
        $this->id_educateur = $id_educateur;

        return $this;
    }

    public function getNomCategorie(): ?categorie
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(?categorie $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    public function getNomLicencie(): ?string
    {
        return $this->nomLicencie;
    }

    public function setNomLicencie(?string $nomLicencie): static
    {
        $this->nomLicencie = $nomLicencie;

        return $this;
    }

    public function getPrenomLicencie(): ?string
    {
        return $this->prenomLicencie;
    }

    public function setPrenomLicencie(?string $prenomLicencie): static
    {
        $this->prenomLicencie = $prenomLicencie;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(?string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

}
