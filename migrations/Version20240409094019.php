<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409094019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ville DROP CONSTRAINT fk_43c3d9c3ccf9e01e');
        $this->addSql('DROP SEQUENCE lieu_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE departement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE region_id_seq CASCADE');
        $this->addSql('ALTER TABLE lieu DROP CONSTRAINT fk_2f577d59a73f0036');
        $this->addSql('ALTER TABLE departement DROP CONSTRAINT fk_c1765b6398260155');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP INDEX idx_43c3d9c3ccf9e01e');
        $this->addSql('ALTER TABLE ville DROP departement_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE lieu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE departement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE region_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE region (id INT NOT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lieu (id INT NOT NULL, ville_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_2f577d59a73f0036 ON lieu (ville_id)');
        $this->addSql('CREATE TABLE departement (id INT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_c1765b6398260155 ON departement (region_id)');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT fk_2f577d59a73f0036 FOREIGN KEY (ville_id) REFERENCES ville (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT fk_c1765b6398260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ville ADD departement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT fk_43c3d9c3ccf9e01e FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_43c3d9c3ccf9e01e ON ville (departement_id)');
    }
}
