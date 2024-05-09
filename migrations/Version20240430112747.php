<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240430112747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE pays_tiers_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE countries_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE countries (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE manifestation_countries (manifestation_id INT NOT NULL, countries_id INT NOT NULL, PRIMARY KEY(manifestation_id, countries_id))');
        $this->addSql('CREATE INDEX IDX_3FD2D9AACD8E394E ON manifestation_countries (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_3FD2D9AAAEBAE514 ON manifestation_countries (countries_id)');
        $this->addSql('ALTER TABLE manifestation_countries ADD CONSTRAINT FK_3FD2D9AACD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_countries ADD CONSTRAINT FK_3FD2D9AAAEBAE514 FOREIGN KEY (countries_id) REFERENCES countries (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pays_tiers DROP CONSTRAINT fk_1df94e99cd8e394e');
        $this->addSql('DROP TABLE pays_tiers');
        $this->addSql('ALTER TABLE manifestation DROP cities');
        $this->addSql('ALTER TABLE manifestation DROP pays');
        $this->addSql('ALTER TABLE ville ADD countries_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3AEBAE514 FOREIGN KEY (countries_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_43C3D9C3AEBAE514 ON ville (countries_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ville DROP CONSTRAINT FK_43C3D9C3AEBAE514');
        $this->addSql('DROP SEQUENCE countries_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pays_tiers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pays_tiers (id INT NOT NULL, manifestation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1df94e99cd8e394e ON pays_tiers (manifestation_id)');
        $this->addSql('ALTER TABLE pays_tiers ADD CONSTRAINT fk_1df94e99cd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_countries DROP CONSTRAINT FK_3FD2D9AACD8E394E');
        $this->addSql('ALTER TABLE manifestation_countries DROP CONSTRAINT FK_3FD2D9AAAEBAE514');
        $this->addSql('DROP TABLE countries');
        $this->addSql('DROP TABLE manifestation_countries');
        $this->addSql('ALTER TABLE manifestation ADD cities VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation ADD pays JSON DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_43C3D9C3AEBAE514');
        $this->addSql('ALTER TABLE ville DROP countries_id');
    }
}
