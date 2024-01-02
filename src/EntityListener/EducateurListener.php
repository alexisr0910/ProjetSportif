<?php

namespace App\EntityListener;

use App\Entity\Educateur;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EducateurListener
{
    private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    public function prePersist(Educateur $educateur): void
    {
        $this->encodePassword($educateur);
    }

    public function preUpdate(Educateur $educateur): void
    {
        $this->encodePassword($educateur);
    }

    public function encodePassword(Educateur $educateur): void
    {
        if ($educateur->getPlainPassword() === null) {
            return;
        }
        $educateur->setPassword($this->passwordHasher->hashPassword($educateur, $educateur->getPlainPassword()));
    }


}