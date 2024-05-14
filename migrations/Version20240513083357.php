<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513083357 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD motif_annulation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD justification_annulation TEXT DEFAULT NULL');
        $this->addSql('DROP INDEX uniq_identifier_username');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_username ON utilisateur (username)');
        $this->addSql('ALTER TABLE project DROP motif_annulation');
        $this->addSql('ALTER TABLE project DROP justification_annulation');
    }
}
