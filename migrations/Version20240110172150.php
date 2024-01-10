<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240110172150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mail_contact (id INT AUTO_INCREMENT NOT NULL, id_contact_id INT DEFAULT NULL, date_envoi DATETIME DEFAULT NULL, object VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, INDEX IDX_96DF6757422BA59D (id_contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_contact_categorie (mail_contact_id INT NOT NULL, categorie_id INT NOT NULL, INDEX IDX_340E21C33362CFB6 (mail_contact_id), INDEX IDX_340E21C3BCF5E72D (categorie_id), PRIMARY KEY(mail_contact_id, categorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_edu (id INT AUTO_INCREMENT NOT NULL, id_educateur_id INT DEFAULT NULL, object VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, date_envoie DATETIME DEFAULT NULL, INDEX IDX_8CB8D4A3483D6F7C (id_educateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mail_edu_educateur (mail_edu_id INT NOT NULL, educateur_id INT NOT NULL, INDEX IDX_7A814C4C9D911D20 (mail_edu_id), INDEX IDX_7A814C4C6BFC1A0E (educateur_id), PRIMARY KEY(mail_edu_id, educateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mail_contact ADD CONSTRAINT FK_96DF6757422BA59D FOREIGN KEY (id_contact_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE mail_contact_categorie ADD CONSTRAINT FK_340E21C33362CFB6 FOREIGN KEY (mail_contact_id) REFERENCES mail_contact (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_contact_categorie ADD CONSTRAINT FK_340E21C3BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_edu ADD CONSTRAINT FK_8CB8D4A3483D6F7C FOREIGN KEY (id_educateur_id) REFERENCES educateur (id)');
        $this->addSql('ALTER TABLE mail_edu_educateur ADD CONSTRAINT FK_7A814C4C9D911D20 FOREIGN KEY (mail_edu_id) REFERENCES mail_edu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mail_edu_educateur ADD CONSTRAINT FK_7A814C4C6BFC1A0E FOREIGN KEY (educateur_id) REFERENCES educateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mail_contact DROP FOREIGN KEY FK_96DF6757422BA59D');
        $this->addSql('ALTER TABLE mail_contact_categorie DROP FOREIGN KEY FK_340E21C33362CFB6');
        $this->addSql('ALTER TABLE mail_contact_categorie DROP FOREIGN KEY FK_340E21C3BCF5E72D');
        $this->addSql('ALTER TABLE mail_edu DROP FOREIGN KEY FK_8CB8D4A3483D6F7C');
        $this->addSql('ALTER TABLE mail_edu_educateur DROP FOREIGN KEY FK_7A814C4C9D911D20');
        $this->addSql('ALTER TABLE mail_edu_educateur DROP FOREIGN KEY FK_7A814C4C6BFC1A0E');
        $this->addSql('DROP TABLE mail_contact');
        $this->addSql('DROP TABLE mail_contact_categorie');
        $this->addSql('DROP TABLE mail_edu');
        $this->addSql('DROP TABLE mail_edu_educateur');
    }
}
