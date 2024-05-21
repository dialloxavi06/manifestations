<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521114313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation ADD ville_fr_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F7E3EE1A FOREIGN KEY (ville_fr_id) REFERENCES commune (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F7E3EE1A ON manifestation (ville_fr_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F7E3EE1A');
        $this->addSql('DROP INDEX IDX_6F2B3F7F7E3EE1A');
        $this->addSql('ALTER TABLE manifestation DROP ville_fr_id');
    }
}
