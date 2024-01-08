<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[UniqueEntity("numeroTel")]

class Contact
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: "contact")]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]

    private ?Licencie $licencie = null;


    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]

    private ?string $nom = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $numeroTel = null;

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

    public function getNumeroTel(): ?string
    {
        return $this->numeroTel;
    }

    public function setNumeroTel(?string $numeroTel): self
    {
        $this->numeroTel = $numeroTel;

        return $this;
    }

    // Ajout des méthodes getLicencie et setLicencie
    public function getLicencie(): ?Licencie
    {
        return $this->licencie;
    }

    public function setLicencie(?Licencie $licencie): self
    {
        $this->licencie = $licencie;

        return $this;
    }
}
