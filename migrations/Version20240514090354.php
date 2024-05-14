<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240514090354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project_kontakt (project_id INT NOT NULL, kontakt_id INT NOT NULL, PRIMARY KEY(project_id, kontakt_id))');
        $this->addSql('CREATE INDEX IDX_214A2E32166D1F9C ON project_kontakt (project_id)');
        $this->addSql('CREATE INDEX IDX_214A2E32C4062E7F ON project_kontakt (kontakt_id)');
        $this->addSql('ALTER TABLE project_kontakt ADD CONSTRAINT FK_214A2E32166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project_kontakt ADD CONSTRAINT FK_214A2E32C4062E7F FOREIGN KEY (kontakt_id) REFERENCES kontakt (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE project_kontakt DROP CONSTRAINT FK_214A2E32166D1F9C');
        $this->addSql('ALTER TABLE project_kontakt DROP CONSTRAINT FK_214A2E32C4062E7F');
        $this->addSql('DROP TABLE project_kontakt');
    }
}
