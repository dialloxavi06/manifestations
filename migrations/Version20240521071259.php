<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521071259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE ville_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE staedte_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE staedte (id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE ville DROP CONSTRAINT fk_43c3d9c3aebae514');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE manifestation ADD staedte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP motif_annulation');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F9CBB1703 FOREIGN KEY (staedte_id) REFERENCES staedte (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F9CBB1703 ON manifestation (staedte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F9CBB1703');
        $this->addSql('DROP SEQUENCE staedte_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE ville_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ville (id INT NOT NULL, countries_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_43c3d9c3aebae514 ON ville (countries_id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT fk_43c3d9c3aebae514 FOREIGN KEY (countries_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP TABLE staedte');
        $this->addSql('DROP INDEX IDX_6F2B3F7F9CBB1703');
        $this->addSql('ALTER TABLE manifestation ADD motif_annulation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation DROP staedte_id');
    }
}
