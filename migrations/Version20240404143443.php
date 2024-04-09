<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240404143443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE manifestation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE manifestation (id INT NOT NULL, project_id_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, date_debut TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, duree VARCHAR(255) DEFAULT NULL, justification_duree VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F6C1197C9 ON manifestation (project_id_id)');
        $this->addSql('COMMENT ON COLUMN manifestation.date_debut IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN manifestation.date_fin IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F6C1197C9 FOREIGN KEY (project_id_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE manifestation_id_seq CASCADE');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F6C1197C9');
        $this->addSql('DROP TABLE manifestation');
    }
}
