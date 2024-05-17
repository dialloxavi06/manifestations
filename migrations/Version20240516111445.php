<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516111445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT fk_2446013ecd8e394e');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT fk_2446013ea73f0036');
        $this->addSql('DROP TABLE manifestation_ville');
        $this->addSql('ALTER TABLE manifestation ADD commune_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP autre_ville');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F131A4F72 ON manifestation (commune_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE manifestation_ville (manifestation_id INT NOT NULL, ville_id INT NOT NULL, PRIMARY KEY(manifestation_id, ville_id))');
        $this->addSql('CREATE INDEX idx_2446013ea73f0036 ON manifestation_ville (ville_id)');
        $this->addSql('CREATE INDEX idx_2446013ecd8e394e ON manifestation_ville (manifestation_id)');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT fk_2446013ecd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT fk_2446013ea73f0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F131A4F72');
        $this->addSql('DROP INDEX IDX_6F2B3F7F131A4F72');
        $this->addSql('ALTER TABLE manifestation ADD autre_ville VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP commune_id');
    }
}
