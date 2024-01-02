<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240102215450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE contact DROP INDEX UNIQ_4C62E638E7A1254A, ADD INDEX IDX_4C62E638E7A1254A (contact_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638E7A1254A');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638E7A1254A FOREIGN KEY (contact_id) REFERENCES licencie (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE educateur CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B755612E7A1254A');
        $this->addSql('DROP INDEX UNIQ_3B755612E7A1254A ON licencie');
        $this->addSql('ALTER TABLE licencie DROP contact_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE contact DROP INDEX IDX_4C62E638E7A1254A, ADD UNIQUE INDEX UNIQ_4C62E638E7A1254A (contact_id)');
        $this->addSql('ALTER TABLE contact DROP FOREIGN KEY FK_4C62E638E7A1254A');
        $this->addSql('ALTER TABLE contact ADD CONSTRAINT FK_4C62E638E7A1254A FOREIGN KEY (contact_id) REFERENCES licencie (id)');
        $this->addSql('ALTER TABLE educateur CHANGE password password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE licencie ADD contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B755612E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B755612E7A1254A ON licencie (contact_id)');
    }
}
