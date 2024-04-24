<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424122130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE pays_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ville_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pays_tiers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pays_tiers (id INT NOT NULL, manifestation_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1DF94E99CD8E394E ON pays_tiers (manifestation_id)');
        $this->addSql('ALTER TABLE pays_tiers ADD CONSTRAINT FK_1DF94E99CD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ville DROP CONSTRAINT fk_43c3d9c3a6e44244');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT fk_2446013ecd8e394e');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT fk_2446013ea73f0036');
        $this->addSql('DROP TABLE ville');
        $this->addSql('DROP TABLE manifestation_ville');
        $this->addSql('DROP TABLE pays');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN pays_tiers TO ville');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pays_tiers_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE pays_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ville_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ville (id INT NOT NULL, pays_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_43c3d9c3a6e44244 ON ville (pays_id)');
        $this->addSql('CREATE TABLE manifestation_ville (manifestation_id INT NOT NULL, ville_id INT NOT NULL, PRIMARY KEY(manifestation_id, ville_id))');
        $this->addSql('CREATE INDEX idx_2446013ea73f0036 ON manifestation_ville (ville_id)');
        $this->addSql('CREATE INDEX idx_2446013ecd8e394e ON manifestation_ville (manifestation_id)');
        $this->addSql('CREATE TABLE pays (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT fk_43c3d9c3a6e44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT fk_2446013ecd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT fk_2446013ea73f0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pays_tiers DROP CONSTRAINT FK_1DF94E99CD8E394E');
        $this->addSql('DROP TABLE pays_tiers');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN ville TO pays_tiers');
    }
}
