<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Educateur;
use App\Entity\Licence;
use App\Entity\Licencie;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    /**
     * Load des valeurs pour Educateur, Contact, Catégories et Licencie
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        // Exemple pour Educateurs
        for ($i = 0; $i < 40; $i++) {
            $educateur = new Educateur();
            $educateur
                ->setEmail('emaileducateur_' . $this->faker->word())
                ->setMdp('motdepasse_' . $this->faker->word());

            $manager->persist($educateur);
        }

        // Exemple pour Contact
        for ($i = 0; $i < 40; $i++) {
            $contact = new Contact();
            $contact
                ->setNom($this->faker->word())
                ->setPrenom($this->faker->word())
                ->setEmail($this->faker->email())
                ->setNumeroTel($this->faker->randomNumber(4, true));

            $manager->persist($contact);
        }

        // Example pour Categorie
        for ($i = 0; $i < 40; $i++) {
            $categorie = new Categorie();
            $categorie
                ->setNomCategorie($this->faker->word())
                ->setCodeRaccourcie($this->faker->randomNumber(2, true));

            $manager->persist($categorie);
        }

        // Exemple pour Licencie
        for ($i = 0; $i < 40; $i++) {
            $licencie = new Licencie();
            $licencie
                ->setContact($contact)
                ->setCategorie($categorie)
                ->setEducateur($educateur)
                ->setNom($this->faker->word())
                ->setPrenom($this->faker->word())
                ->setNumLicence(mt_rand(0, 9999));

            $manager->persist($licencie);
        }

        $this->loadUserFixtures($manager);

        $manager->flush();
    }
    /**
     * Load des valeurs pour les users 
     *
     * @param ObjectManager $manager
     * @return void
     */
    private function loadUserFixtures(ObjectManager $manager): void
    {

        $usersData = [
            ['email' => 'alexis@hotmail.com', 'roles' => ['ROLE_ADMIN'], 'password' => 'azerty1'],
            ['email' => 'lisa@hotmail.com', 'roles' => ['ROLE_ADMIN'], 'password' => 'azerty12'],
            ['email' => 'christian@hotmail.com', 'roles' => ['ROLE_USER'], 'password' => 'azerty123'],
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user
                ->setEmail($userData['email'])
                ->setRoles($userData['roles'])
                ->setPassword($userData['password']);

            $manager->persist($user);
        }
        /* 
                $user1 = new User();
                $user1
                    ->setEmail('alexis@hotmail.com')
                    ->setRoles(['ROLE_ADMIN'])
                    ->setPassword('azerty1');
                $manager->persist($user1);

                $user2 = new User();
                $user2
                    ->setEmail('lisa@hotmail.com')
                    ->setRoles(['ROLE_ADMIN'])
                    ->setPassword('azerty12');
                $manager->persist($user2);

                $user3 = new User();
                $user3
                    ->setEmail('christian@hotmail.com')
                    ->setRoles(['ROLE_USER'])
                    ->setPassword('azerty123');
                $manager->persist($user3);
         */

        $manager->flush();
    }
}
