<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227164311 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, id_categorie BIGINT DEFAULT NULL, nom_categorie VARCHAR(255) DEFAULT NULL, code_raccourcie VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, id_contact BIGINT DEFAULT NULL, nom_contact VARCHAR(255) DEFAULT NULL, prenom_contact VARCHAR(255) DEFAULT NULL, email_contact VARCHAR(255) DEFAULT NULL, numero_tel BIGINT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educateur (id INT AUTO_INCREMENT NOT NULL, id_educateur BIGINT DEFAULT NULL, email_educateur VARCHAR(255) DEFAULT NULL, mdp VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licencie (id INT AUTO_INCREMENT NOT NULL, id_contact_id INT DEFAULT NULL, id_educateur_id INT DEFAULT NULL, nom_categorie_id INT DEFAULT NULL, id_licencie BIGINT DEFAULT NULL, nom_licencie VARCHAR(255) DEFAULT NULL, prenom_licencie VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3B755612422BA59D (id_contact_id), UNIQUE INDEX UNIQ_3B755612483D6F7C (id_educateur_id), INDEX IDX_3B75561231338A73 (nom_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612422BA59D FOREIGN KEY (id_contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612483D6F7C FOREIGN KEY (id_educateur_id) REFERENCES educateur (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B75561231338A73 FOREIGN KEY (nom_categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612422BA59D');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612483D6F7C');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B75561231338A73');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE educateur');
        $this->addSql('DROP TABLE licencie');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
