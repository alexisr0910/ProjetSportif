<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240101172353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) DEFAULT NULL, code_raccourcie VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, numero_tel VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4C62E638E7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE educateur (id INT AUTO_INCREMENT NOT NULL, educateur_id INT DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, mdp VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_763C01226BFC1A0E (educateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE licencie (id INT AUTO_INCREMENT NOT NULL, contact_id INT DEFAULT NULL, educateur_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, num_licence INT DEFAULT NULL, UNIQUE INDEX UNIQ_3B755612E7A1254A (contact_id), UNIQUE INDEX UNIQ_3B7556126BFC1A0E (educateur_id), INDEX IDX_3B755612BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638E7A1254A FOREIGN KEY (contact_id) REFERENCES licencie (id)');
        $this->addSql('ALTER TABLE educateur ADD CONSTRAINT FK_763C01226BFC1A0E FOREIGN KEY (educateur_id) REFERENCES licencie (id)');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B7556126BFC1A0E FOREIGN KEY (educateur_id) REFERENCES educateur (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638E7A1254A');
        $this->addSql('ALTER TABLE educateur DROP FOREIGN KEY FK_763C01226BFC1A0E');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612E7A1254A');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B7556126BFC1A0E');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612BCF5E72D');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE educateur');
        $this->addSql('DROP TABLE licencie');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
