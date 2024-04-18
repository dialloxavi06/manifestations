<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418130137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP CONSTRAINT fk_2fb3d0ee6bf700bd');
        $this->addSql('DROP SEQUENCE statut_projet_id_seq CASCADE');
        $this->addSql('DROP TABLE statut_projet');
        $this->addSql('DROP INDEX idx_2fb3d0ee6bf700bd');
        $this->addSql('ALTER TABLE project DROP status_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE statut_projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE statut_projet (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE project ADD status_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT fk_2fb3d0ee6bf700bd FOREIGN KEY (status_id) REFERENCES statut_projet (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2fb3d0ee6bf700bd ON project (status_id)');
    }
}
