<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514082142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE porteurs_de_projet_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE kontakt_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE kontakt (id INT NOT NULL, role_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telefone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B7542257D60322AC ON kontakt (role_id)');
        $this->addSql('CREATE TABLE kontakt_project (kontakt_id INT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(kontakt_id, project_id))');
        $this->addSql('CREATE INDEX IDX_69C27D1CC4062E7F ON kontakt_project (kontakt_id)');
        $this->addSql('CREATE INDEX IDX_69C27D1C166D1F9C ON kontakt_project (project_id)');
        $this->addSql('ALTER TABLE kontakt ADD CONSTRAINT FK_B7542257D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE kontakt_project ADD CONSTRAINT FK_69C27D1CC4062E7F FOREIGN KEY (kontakt_id) REFERENCES kontakt (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE kontakt_project ADD CONSTRAINT FK_69C27D1C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE porteurs_de_projet_project DROP CONSTRAINT fk_2a07c7d064b23785');
        $this->addSql('ALTER TABLE porteurs_de_projet_project DROP CONSTRAINT fk_2a07c7d0166d1f9c');
        $this->addSql('ALTER TABLE porteurs_de_projet DROP CONSTRAINT fk_2a3714c7d60322ac');
        $this->addSql('DROP TABLE porteurs_de_projet_project');
        $this->addSql('DROP TABLE porteurs_de_projet');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE kontakt_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE porteurs_de_projet_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE porteurs_de_projet_project (porteurs_de_projet_id INT NOT NULL, project_id INT NOT NULL, PRIMARY KEY(porteurs_de_projet_id, project_id))');
        $this->addSql('CREATE INDEX idx_2a07c7d0166d1f9c ON porteurs_de_projet_project (project_id)');
        $this->addSql('CREATE INDEX idx_2a07c7d064b23785 ON porteurs_de_projet_project (porteurs_de_projet_id)');
        $this->addSql('CREATE TABLE porteurs_de_projet (id INT NOT NULL, role_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telefone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_2a3714c7d60322ac ON porteurs_de_projet (role_id)');
        $this->addSql('ALTER TABLE porteurs_de_projet_project ADD CONSTRAINT fk_2a07c7d064b23785 FOREIGN KEY (porteurs_de_projet_id) REFERENCES porteurs_de_projet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE porteurs_de_projet_project ADD CONSTRAINT fk_2a07c7d0166d1f9c FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE porteurs_de_projet ADD CONSTRAINT fk_2a3714c7d60322ac FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE kontakt DROP CONSTRAINT FK_B7542257D60322AC');
        $this->addSql('ALTER TABLE kontakt_project DROP CONSTRAINT FK_69C27D1CC4062E7F');
        $this->addSql('ALTER TABLE kontakt_project DROP CONSTRAINT FK_69C27D1C166D1F9C');
        $this->addSql('DROP TABLE kontakt');
        $this->addSql('DROP TABLE kontakt_project');
    }
}
