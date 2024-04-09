<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408133608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT fk_6f2b3f7fa73f0036');
        $this->addSql('DROP INDEX idx_6f2b3f7fa73f0036');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN ville_id TO region_id');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F98260155 ON manifestation (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F98260155');
        $this->addSql('DROP INDEX IDX_6F2B3F7F98260155');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN region_id TO ville_id');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT fk_6f2b3f7fa73f0036 FOREIGN KEY (ville_id) REFERENCES ville (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6f2b3f7fa73f0036 ON manifestation (ville_id)');
    }
}
