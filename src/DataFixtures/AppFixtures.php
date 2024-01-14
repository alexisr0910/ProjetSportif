<?php
namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Educateur;
use App\Entity\Licencie;
use App\Entity\MailContact;
use App\Entity\MailEdu;
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
     * Fixtures pour les entités
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {

            $educateur = new Educateur();
            $password = $this->faker->password();
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $educateur
                ->setEmail($this->faker->email())
                ->setPassword($hashedPassword)     
                 ->setRoles($this->faker->randomElement([['ROLE_ADMIN'], ['ROLE_EDUCATEUR']]));

            $manager->persist($educateur);


            $categorie = new Categorie();
            $categorie
                ->setNomCategorie($this->faker->word())
                ->setCodeRaccourcie($this->faker->word());
            $manager->persist($categorie);
            $licencie = new Licencie();
            $licencie
                ->setCategorie($categorie)
                ->setEducateur($educateur)
                ->setNom($this->faker->lastName())
                ->setPrenom($this->faker->randomElement([$this->faker->firstNameMale(), $this->faker->firstNameFemale()]))
                ->setNumLicence(mt_rand(0, 9999));

            $manager->persist($licencie);

            $contact = new Contact();
            $contact
                ->setLicencie($licencie)
                ->setNom($this->faker->lastName())
                ->setPrenom($this->faker->randomElement([$this->faker->firstNameMale(), $this->faker->firstNameFemale()]))
                ->setEmail($this->faker->email())
                ->setNumeroTel($this->faker->e164PhoneNumber());
            $manager->persist($contact);

            $mailEdu = new MailEdu();
            $mailEdu
                ->setObject($this->faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setMessage($this->faker->text($maxNbChars = 200))
                ->setIdEducateur($educateur)
                ->setDateEnvoie($this->faker->dateTimeBetween('-1 month', 'now'));
            $mailEdu->addDestinataire($educateur);
            $manager->persist($mailEdu);

            $mailContact = new MailContact();
            $mailContact
                ->setObject($this->faker->sentence($nbWords = 6, $variableNbWords = true))
                ->setMessage($this->faker->text($maxNbChars = 200))
                ->setIdContact($contact)
                ->setDateEnvoi($this->faker->dateTimeBetween('-1 month', 'now'));
            $mailContact->addDestinataire($categorie);

            $manager->persist($mailContact);

        }
        $manager->flush();
    }
}