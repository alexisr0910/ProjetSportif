<?php

namespace App\Entity;

use App\Repository\MailEduRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MailEduRepository::class)]
class MailEdu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $object = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnvoie = null;

    #[ORM\ManyToOne(inversedBy: 'mailEdus')]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?Educateur $idEducateur = null;

    #[ORM\ManyToMany(targetEntity: Educateur::class, inversedBy: 'mailEdus')]
    private Collection $destinataires;
    
    public function __construct()
    {
        $this->destinataires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(?string $object): static
    {
        $this->object = $object;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getIdEducateur(): ?Educateur
    {
        return $this->idEducateur;
    }

    public function setIdEducateur(?Educateur $idEducateur): static
    {
        $this->idEducateur = $idEducateur;

        return $this;
    }

    /**
     * @return Collection<int, Educateur>
     */
    public function getDestinataires(): Collection
    {
        return $this->destinataires;
    }

    public function addDestinataire(Educateur $destinataire): static
    {
        if (!$this->destinataires->contains($destinataire)) {
            $this->destinataires->add($destinataire);
        }

        return $this;
    }

    public function removeDestinataire(Educateur $destinataire): static
    {
        $this->destinataires->removeElement($destinataire);

        return $this;
    }

    public function getDateEnvoie(): ?\DateTimeInterface
    {
        return $this->dateEnvoie;
    }

    public function setDateEnvoie(?\DateTimeInterface $dateEnvoie): static
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }
}
