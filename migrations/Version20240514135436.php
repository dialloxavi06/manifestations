<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514135436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE institution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE type_institution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE institution (id INT NOT NULL, type_institution_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3A9F98E546837012 ON institution (type_institution_id)');
        $this->addSql('CREATE TABLE kontakt_institution (kontakt_id INT NOT NULL, institution_id INT NOT NULL, PRIMARY KEY(kontakt_id, institution_id))');
        $this->addSql('CREATE INDEX IDX_6ECB24E8C4062E7F ON kontakt_institution (kontakt_id)');
        $this->addSql('CREATE INDEX IDX_6ECB24E810405986 ON kontakt_institution (institution_id)');
        $this->addSql('CREATE TABLE type_institution (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE institution ADD CONSTRAINT FK_3A9F98E546837012 FOREIGN KEY (type_institution_id) REFERENCES type_institution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE kontakt_institution ADD CONSTRAINT FK_6ECB24E8C4062E7F FOREIGN KEY (kontakt_id) REFERENCES kontakt (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE kontakt_institution ADD CONSTRAINT FK_6ECB24E810405986 FOREIGN KEY (institution_id) REFERENCES institution (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE institution_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE type_institution_id_seq CASCADE');
        $this->addSql('ALTER TABLE institution DROP CONSTRAINT FK_3A9F98E546837012');
        $this->addSql('ALTER TABLE kontakt_institution DROP CONSTRAINT FK_6ECB24E8C4062E7F');
        $this->addSql('ALTER TABLE kontakt_institution DROP CONSTRAINT FK_6ECB24E810405986');
        $this->addSql('DROP TABLE institution');
        $this->addSql('DROP TABLE kontakt_institution');
        $this->addSql('DROP TABLE type_institution');
    }
}
