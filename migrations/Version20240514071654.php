<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514071654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE porteurs_de_projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE role_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE porteurs_de_projet (id INT NOT NULL, role_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telefone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2A3714C7D60322AC ON porteurs_de_projet (role_id)');
        $this->addSql('CREATE TABLE porteurs_de_projet_project (porteurs_de_projet_id INT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(porteurs_de_projet_id, project_id))');
        $this->addSql('CREATE INDEX IDX_2A07C7D064B23785 ON porteurs_de_projet_project (porteurs_de_projet_id)');
        $this->addSql('CREATE INDEX IDX_2A07C7D0166D1F9C ON porteurs_de_projet_project (project_id)');
        $this->addSql('CREATE TABLE role (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE porteurs_de_projet ADD CONSTRAINT FK_2A3714C7D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE porteurs_de_projet_project ADD CONSTRAINT FK_2A07C7D064B23785 FOREIGN KEY (porteurs_de_projet_id) REFERENCES porteurs_de_projet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE porteurs_de_projet_project ADD CONSTRAINT FK_2A07C7D0166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE porteurs_de_projet_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE role_id_seq CASCADE');
        $this->addSql('ALTER TABLE porteurs_de_projet DROP CONSTRAINT FK_2A3714C7D60322AC');
        $this->addSql('ALTER TABLE porteurs_de_projet_project DROP CONSTRAINT FK_2A07C7D064B23785');
        $this->addSql('ALTER TABLE porteurs_de_projet_project DROP CONSTRAINT FK_2A07C7D0166D1F9C');
        $this->addSql('DROP TABLE porteurs_de_projet');
        $this->addSql('DROP TABLE porteurs_de_projet_project');
        $this->addSql('DROP TABLE role');
    }
}
