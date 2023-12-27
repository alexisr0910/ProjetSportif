<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227205701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638526E8E58');
        $this->addSql('DROP INDEX UNIQ_4C62E638526E8E58 ON contact');
        $this->addSql('ALTER TABLE contact CHANGE contact_id_id contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638E7A1254A FOREIGN KEY (contact_id) REFERENCES licencie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638E7A1254A ON contact (contact_id)');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612526E8E58');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B7556128A3C7387');
        $this->addSql('DROP INDEX UNIQ_3B755612526E8E58 ON licencie');
        $this->addSql('DROP INDEX IDX_3B7556128A3C7387 ON licencie');
        $this->addSql('ALTER TABLE licencie ADD contact_id INT DEFAULT NULL, ADD categorie_id INT DEFAULT NULL, DROP contact_id_id, DROP categorie_id_id');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B755612E7A1254A ON licencie (contact_id)');
        $this->addSql('CREATE INDEX IDX_3B755612BCF5E72D ON licencie (categorie_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638E7A1254A');
        $this->addSql('DROP INDEX UNIQ_4C62E638E7A1254A ON contact');
        $this->addSql('ALTER TABLE contact CHANGE contact_id contact_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638526E8E58 FOREIGN KEY (contact_id_id) REFERENCES licencie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4C62E638526E8E58 ON contact (contact_id_id)');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612E7A1254A');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612BCF5E72D');
        $this->addSql('DROP INDEX UNIQ_3B755612E7A1254A ON licencie');
        $this->addSql('DROP INDEX IDX_3B755612BCF5E72D ON licencie');
        $this->addSql('ALTER TABLE licencie ADD contact_id_id INT DEFAULT NULL, ADD categorie_id_id INT DEFAULT NULL, DROP contact_id, DROP categorie_id');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612526E8E58 FOREIGN KEY (contact_id_id) REFERENCES contact (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B7556128A3C7387 FOREIGN KEY (categorie_id_id) REFERENCES categorie (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B755612526E8E58 ON licencie (contact_id_id)');
        $this->addSql('CREATE INDEX IDX_3B7556128A3C7387 ON licencie (categorie_id_id)');
    }
}
