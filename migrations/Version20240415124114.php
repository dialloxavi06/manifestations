<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240415124114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manifestation_ville (manifestation_id INT NOT NULL, ville_id INT NOT NULL, PRIMARY KEY(manifestation_id, ville_id))');
        $this->addSql('CREATE INDEX IDX_2446013ECD8E394E ON manifestation_ville (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_2446013EA73F0036 ON manifestation_ville (ville_id)');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT FK_2446013ECD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT FK_2446013EA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT FK_2446013ECD8E394E');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT FK_2446013EA73F0036');
        $this->addSql('DROP TABLE manifestation_ville');
    }
}
