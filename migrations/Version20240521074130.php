<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521074130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manifestation_commune (manifestation_id INT NOT NULL, commune_id INT NOT NULL, PRIMARY KEY(manifestation_id, commune_id))');
        $this->addSql('CREATE INDEX IDX_CBF8737DCD8E394E ON manifestation_commune (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_CBF8737D131A4F72 ON manifestation_commune (commune_id)');
        $this->addSql('ALTER TABLE manifestation_commune ADD CONSTRAINT FK_CBF8737DCD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_commune ADD CONSTRAINT FK_CBF8737D131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT fk_6f2b3f7f131a4f72');
        $this->addSql('DROP INDEX idx_6f2b3f7f131a4f72');
        $this->addSql('ALTER TABLE manifestation DROP commune_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation_commune DROP CONSTRAINT FK_CBF8737DCD8E394E');
        $this->addSql('ALTER TABLE manifestation_commune DROP CONSTRAINT FK_CBF8737D131A4F72');
        $this->addSql('DROP TABLE manifestation_commune');
        $this->addSql('ALTER TABLE manifestation ADD commune_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT fk_6f2b3f7f131a4f72 FOREIGN KEY (commune_id) REFERENCES commune (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6f2b3f7f131a4f72 ON manifestation (commune_id)');
    }
}
