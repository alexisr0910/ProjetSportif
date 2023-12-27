<?php

namespace App\Entity;

use App\Repository\EducateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EducateurRepository::class)]
class Educateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_educateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailEducateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mdp = null;

    #[ORM\OneToOne(mappedBy: 'id_educateur', cascade: ['persist', 'remove'])]
    private ?Licencie $accessLicencie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEducateur(): ?string
    {
        return $this->id_educateur;
    }

    public function setIdEducateur(?string $id_educateur): static
    {
        $this->id_educateur = $id_educateur;

        return $this;
    }

    public function getEmailEducateur(): ?string
    {
        return $this->emailEducateur;
    }

    public function setEmailEducateur(?string $emailEducateur): static
    {
        $this->emailEducateur = $emailEducateur;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(?string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getAccessLicencie(): ?Licencie
    {
        return $this->accessLicencie;
    }

    public function setAccessLicencie(?Licencie $accessLicencie): static
    {
        // unset the owning side of the relation if necessary
        if ($accessLicencie === null && $this->accessLicencie !== null) {
            $this->accessLicencie->setIdEducateur(null);
        }

        // set the owning side of the relation if necessary
        if ($accessLicencie !== null && $accessLicencie->getIdEducateur() !== $this) {
            $accessLicencie->setIdEducateur($this);
        }

        $this->accessLicencie = $accessLicencie;

        return $this;
    }
}
