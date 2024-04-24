<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424102015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation ADD titre_fr VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation ADD titre_de VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation ADD titre_en VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP titre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation ADD titre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE manifestation DROP titre_fr');
        $this->addSql('ALTER TABLE manifestation DROP titre_de');
        $this->addSql('ALTER TABLE manifestation DROP titre_en');
    }
}
