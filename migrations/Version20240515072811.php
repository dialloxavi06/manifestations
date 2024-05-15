<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240515072811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE adresse_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE adresse (id INT NOT NULL, numero INT DEFAULT NULL, nom_rue VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE institution ADD adresse VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE kontakt ADD adresse_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE kontakt ADD CONSTRAINT FK_B75422574DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B75422574DE7DC5C ON kontakt (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE kontakt DROP CONSTRAINT FK_B75422574DE7DC5C');
        $this->addSql('DROP SEQUENCE adresse_id_seq CASCADE');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP INDEX IDX_B75422574DE7DC5C');
        $this->addSql('ALTER TABLE kontakt DROP adresse_id');
        $this->addSql('ALTER TABLE institution DROP adresse');
    }
}
