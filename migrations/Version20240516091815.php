<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516091815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE region_id_seq1 CASCADE');
        $this->addSql('CREATE SEQUENCE commune_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE commune (id INT NOT NULL, departement_id INT DEFAULT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E2E2D1EECCF9E01E ON commune (departement_id)');
        $this->addSql('CREATE INDEX IDX_E2E2D1EE98260155 ON commune (region_id)');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commune ADD CONSTRAINT FK_E2E2D1EE98260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE region ALTER id DROP DEFAULT');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE commune_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE region_id_seq1 INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE commune DROP CONSTRAINT FK_E2E2D1EECCF9E01E');
        $this->addSql('ALTER TABLE commune DROP CONSTRAINT FK_E2E2D1EE98260155');
        $this->addSql('DROP TABLE commune');
        $this->addSql('CREATE SEQUENCE region_id_seq');
        $this->addSql('SELECT setval(\'region_id_seq\', (SELECT MAX(id) FROM region))');
        $this->addSql('ALTER TABLE region ALTER id SET DEFAULT nextval(\'region_id_seq\')');
        $this->addSql('ALTER TABLE departement DROP CONSTRAINT FK_C1765B6398260155');
    }
}
