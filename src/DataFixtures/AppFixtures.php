<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Educateur;
use App\Entity\Licence;
use App\Entity\Licencie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Generator;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $licencie = new Licencie();
            $licencie
                ->setIdLicencie(mt_rand(29999, 40000))
                ->setNomLicencie('NomLicencie ' . $this->faker->word())
                ->setPrenomLicencie('PrenomLicencie  ' . $this->faker->word())
                ->setCategorie('categorie' . $this->faker->word());
            $manager->persist($licencie);

            $educateur = new Educateur();
            $educateur
                ->setIdEducateur(mt_rand(0, 9999))
                ->setEmailEducateur('emaileducateur  ' . $this->faker->word())
                ->setMdp('motdepasse  ' . $this->faker->word());

            $manager->persist($educateur);

            $contact = new Contact();
            $contact
                ->setIdContact(mt_rand(10000, 19999))
                ->setNomContact('nomContact  ' . $this->faker->word())
                ->setPrenomContact('prenomContact  ' . $this->faker->word())
                ->setEmailContact('emailContact  ' . $i)
                ->setNumeroTel($this->faker->randomNumber(4, true));

            $manager->persist($contact);


            $categorie = new Categorie();
            $categorie
                ->setIdCategorie(mt_rand(19999, 29999))
                ->setNomCategorie('m  ' . $this->faker->word())
                ->setCodeRaccourcie('m' . $this->faker->randomNumber(2, true));

            $manager->persist($categorie);
        }

        $manager->flush();

    }
}
