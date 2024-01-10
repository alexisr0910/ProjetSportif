<?php
namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Contact;
use App\Entity\Educateur;
use App\Entity\Licence;
use App\Entity\Licencie;
use App\Entity\MailContact;
use App\Entity\MailEdu;
use App\Entity\User;
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
        for ($i = 0; $i < 40; $i++) {

            $educateur = new Educateur();
            $educateur
                ->setEmail('email@email.email' . $i)
                ->setPassword('motdepasse' . $i)
                ->setRoles($this->faker->randomElement([['ROLE_ADMIN'], ['ROLE_EDUCATEUR']]));

            $manager->persist($educateur);


            $categorie = new Categorie();
            $categorie
                ->setNomCategorie('m  ' . $this->faker->word())
                ->setCodeRaccourcie('m' . $this->faker->randomNumber(2, true));
            $manager->persist($categorie);
            $licencie = new Licencie();
            $licencie
                ->setCategorie($categorie)
                ->setEducateur($educateur)
                ->setNom('NomLicencie ' . $this->faker->word())
                ->setPrenom('PrenomLicencie  ' . $this->faker->word())
                ->setNumLicence(mt_rand(0, 9999));

            $manager->persist($licencie);

            $contact = new Contact();
            $contact
                ->setLicencie($licencie)
                ->setNom('nomContact  ' . $this->faker->word())
                ->setPrenom('prenomContact  ' . $this->faker->word())
                ->setEmail('emailContact  ' . $i)
                ->setNumeroTel($this->faker->randomNumber(4, true));
            $manager->persist($contact);

            $mailEdu = new MailEdu();
            $mailEdu
                ->setObject('Objet du mail éducateur ' . $this->faker->word())
                ->setMessage('Contenu du mail éducateur ' . $this->faker->sentence())
                ->setIdEducateur($educateur)
                ->setDateEnvoie($this->faker->dateTimeBetween('-1 month', 'now'));
            $mailEdu->addDestinataire($educateur);
            $manager->persist($mailEdu);

            // Nouveau code pour MailContact
            $mailContact = new MailContact();
            $mailContact
                ->setObject('Objet du mail contact ' . $this->faker->word())
                ->setMessage('Contenu du mail contact ' . $this->faker->sentence())
                ->setIdContact($contact)
                ->setDateEnvoi($this->faker->dateTimeBetween('-1 month', 'now'));
            $mailContact->addDestinataire($categorie);

            $manager->persist($mailContact);

        }

        /*   $user1 = new User();
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
          $manager->persist($user3); */
        $manager->flush();
    }
}