<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409082805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT fk_6f2b3f7fa6e44244');
        $this->addSql('DROP INDEX idx_6f2b3f7fa6e44244');
        $this->addSql('ALTER TABLE manifestation ADD pays VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP pays_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation ADD pays_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP pays');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT fk_6f2b3f7fa6e44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6f2b3f7fa6e44244 ON manifestation (pays_id)');
    }
}
