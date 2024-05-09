<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240425112118 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE ville_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE manifestation_ville (manifestation_id INT NOT NULL, ville_id INT NOT NULL, PRIMARY KEY(manifestation_id, ville_id))');
        $this->addSql('CREATE INDEX IDX_2446013ECD8E394E ON manifestation_ville (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_2446013EA73F0036 ON manifestation_ville (ville_id)');
        $this->addSql('CREATE TABLE ville (id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT FK_2446013ECD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_ville ADD CONSTRAINT FK_2446013EA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT fk_6f2b3f7f6c1197c9');
        $this->addSql('DROP INDEX idx_6f2b3f7f6c1197c9');
        $this->addSql('ALTER TABLE manifestation DROP ville');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN project_id_id TO project_id');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F166D1F9C ON manifestation (project_id)');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_2fb3d0eea5522701');
        $this->addSql('DROP INDEX idx_2fb3d0eea5522701');
        $this->addSql('ALTER TABLE project ADD titre_de VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD titre_en VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project DROP discipline_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE ville_id_seq CASCADE');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT FK_2446013ECD8E394E');
        $this->addSql('ALTER TABLE manifestation_ville DROP CONSTRAINT FK_2446013EA73F0036');
        $this->addSql('DROP TABLE manifestation_ville');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F166D1F9C');
        $this->addSql('DROP INDEX IDX_6F2B3F7F166D1F9C');
        $this->addSql('ALTER TABLE manifestation ADD ville VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN project_id TO project_id_id');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT fk_6f2b3f7f6c1197c9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6f2b3f7f6c1197c9 ON manifestation (project_id_id)');
        $this->addSql('ALTER TABLE project ADD discipline_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project DROP titre_de');
        $this->addSql('ALTER TABLE project DROP titre_en');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_2fb3d0eea5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2fb3d0eea5522701 ON project (discipline_id)');
    }
}
