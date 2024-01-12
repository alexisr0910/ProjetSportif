<?php

namespace App\Entity;

use App\Repository\EducateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EducateurRepository::class)]
#[ORM\EntityListeners(['App\EntityListener\EducateurListener'])]
#[UniqueEntity('email')]
class Educateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'educateur', cascade: ['persist', 'remove'])]
    private ?Licencie $educateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank()]
    private ?string $email = null;

    /**
     * @var string Le mot de passe hashé
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Le mot de passe est obligatoire.')]
    private ?string $password = 'password';

    private ?string $plainPassword = null;

    #[ORM\Column(type: 'json')]
    #[Assert\NotBlank(message: 'Le champ est obligatoire.')]
    private array $roles = [];

    #[ORM\OneToMany(mappedBy: 'idEducateur', targetEntity: MailEdu::class)]
    private Collection $mailEdus;

    public function __construct()
    {
        $this->mailEdus = new ArrayCollection();
    }


    public function getEducateur(): ?Licencie
    {
        return $this->educateur;
    }

    public function setEducateur(?Licencie $educateur): static
    {
        $this->educateur = $educateur;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): static
    {
        $this->password = $password;

        return $this;
    }


    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        $roles[] = 'ROLE_EDUCATEUR';

        if (in_array('ROLE_ADMIN', $roles)) {
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): static
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function eraseCredentials(): void
    {
        // Si vous stockez des données temporaires ou sensibles sur l'utilisateur, effacez-les ici
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, MailEdu>
     */
    public function getMailEdus(): Collection
    {
        return $this->mailEdus;
    }

    public function addMailEdu(MailEdu $mailEdu): static
    {
        if (!$this->mailEdus->contains($mailEdu)) {
            $this->mailEdus->add($mailEdu);
            $mailEdu->setIdEducateur($this);
        }

        return $this;
    }

    public function removeMailEdu(MailEdu $mailEdu): static
    {
        if ($this->mailEdus->removeElement($mailEdu)) {
            if ($mailEdu->getIdEducateur() === $this) {
                $mailEdu->setIdEducateur(null);
            }
        }

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->getEducateur() ? $this->getEducateur()->getContacts() : null;
    }
}