<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521075940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation ADD staedte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F9CBB1703 FOREIGN KEY (staedte_id) REFERENCES staedte (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F9CBB1703 ON manifestation (staedte_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F9CBB1703');
        $this->addSql('DROP INDEX IDX_6F2B3F7F9CBB1703');
        $this->addSql('ALTER TABLE manifestation DROP staedte_id');
    }
}
