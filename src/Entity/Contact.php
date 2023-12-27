<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $id_contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenomContact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailContact = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $numeroTel = null;

    #[ORM\OneToOne(mappedBy: 'id_contact', cascade: ['persist', 'remove'])]
    private ?Licencie $accessLicencie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdContact(): ?string
    {
        return $this->id_contact;
    }

    public function setIdContact(?string $id_contact): static
    {
        $this->id_contact = $id_contact;

        return $this;
    }

    public function getNomContact(): ?string
    {
        return $this->nomContact;
    }

    public function setNomContact(?string $nomContact): static
    {
        $this->nomContact = $nomContact;

        return $this;
    }

    public function getPrenomContact(): ?string
    {
        return $this->prenomContact;
    }

    public function setPrenomContact(?string $prenomContact): static
    {
        $this->prenomContact = $prenomContact;

        return $this;
    }

    public function getEmailContact(): ?string
    {
        return $this->emailContact;
    }

    public function setEmailContact(?string $emailContact): static
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    public function getNumeroTel(): ?string
    {
        return $this->numeroTel;
    }

    public function setNumeroTel(?string $numeroTel): static
    {
        $this->numeroTel = $numeroTel;

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
            $this->accessLicencie->setIdContact(null);
        }

        // set the owning side of the relation if necessary
        if ($accessLicencie !== null && $accessLicencie->getIdContact() !== $this) {
            $accessLicencie->setIdContact($this);
        }

        $this->accessLicencie = $accessLicencie;

        return $this;
    }
}
