<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521091715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE staedte ADD pays_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE staedte ADD CONSTRAINT FK_41A0490AA6E44244 FOREIGN KEY (pays_id) REFERENCES countries (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_41A0490AA6E44244 ON staedte (pays_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE staedte DROP CONSTRAINT FK_41A0490AA6E44244');
        $this->addSql('DROP INDEX IDX_41A0490AA6E44244');
        $this->addSql('ALTER TABLE staedte DROP pays_id');
    }
}
