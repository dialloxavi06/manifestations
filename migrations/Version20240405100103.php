<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405100103 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE lieu_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lieu (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lieu_manifestation (lieu_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(lieu_id, manifestation_id))');
        $this->addSql('CREATE INDEX IDX_E9799FE46AB213CC ON lieu_manifestation (lieu_id)');
        $this->addSql('CREATE INDEX IDX_E9799FE4CD8E394E ON lieu_manifestation (manifestation_id)');
        $this->addSql('ALTER TABLE lieu_manifestation ADD CONSTRAINT FK_E9799FE46AB213CC FOREIGN KEY (lieu_id) REFERENCES lieu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lieu_manifestation ADD CONSTRAINT FK_E9799FE4CD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE lieu_id_seq CASCADE');
        $this->addSql('ALTER TABLE lieu_manifestation DROP CONSTRAINT FK_E9799FE46AB213CC');
        $this->addSql('ALTER TABLE lieu_manifestation DROP CONSTRAINT FK_E9799FE4CD8E394E');
        $this->addSql('DROP TABLE lieu');
        $this->addSql('DROP TABLE lieu_manifestation');
    }
}
