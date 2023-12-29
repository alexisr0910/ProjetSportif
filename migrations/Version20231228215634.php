<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228215634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur ADD educateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE educateur ADD CONSTRAINT FK_763C01226BFC1A0E FOREIGN KEY (educateur_id) REFERENCES licencie (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_763C01226BFC1A0E ON educateur (educateur_id)');
        $this->addSql('ALTER TABLE licencie ADD educateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE licencie ADD CONSTRAINT FK_3B7556126BFC1A0E FOREIGN KEY (educateur_id) REFERENCES contact (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3B7556126BFC1A0E ON licencie (educateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE educateur DROP FOREIGN KEY FK_763C01226BFC1A0E');
        $this->addSql('DROP INDEX UNIQ_763C01226BFC1A0E ON educateur');
        $this->addSql('ALTER TABLE educateur DROP educateur_id');
        $this->addSql('ALTER TABLE licencie DROP FOREIGN KEY FK_3B7556126BFC1A0E');
        $this->addSql('DROP INDEX UNIQ_3B7556126BFC1A0E ON licencie');
        $this->addSql('ALTER TABLE licencie DROP educateur_id');
    }
}
