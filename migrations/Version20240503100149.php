<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240503100149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE status (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE status_manifestation (status_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(status_id, manifestation_id))');
        $this->addSql('CREATE INDEX IDX_42E36EEA6BF700BD ON status_manifestation (status_id)');
        $this->addSql('CREATE INDEX IDX_42E36EEACD8E394E ON status_manifestation (manifestation_id)');
        $this->addSql('ALTER TABLE status_manifestation ADD CONSTRAINT FK_42E36EEA6BF700BD FOREIGN KEY (status_id) REFERENCES status (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE status_manifestation ADD CONSTRAINT FK_42E36EEACD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE status_id_seq CASCADE');
        $this->addSql('ALTER TABLE status_manifestation DROP CONSTRAINT FK_42E36EEA6BF700BD');
        $this->addSql('ALTER TABLE status_manifestation DROP CONSTRAINT FK_42E36EEACD8E394E');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE status_manifestation');
    }
}
