<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521075113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE manifestation_commune DROP CONSTRAINT fk_cbf8737dcd8e394e');
        $this->addSql('ALTER TABLE manifestation_commune DROP CONSTRAINT fk_cbf8737d131a4f72');
        $this->addSql('DROP TABLE manifestation_commune');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT fk_6f2b3f7f9cbb1703');
        $this->addSql('DROP INDEX idx_6f2b3f7f9cbb1703');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN staedte_id TO commune_id');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT FK_6F2B3F7F131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6F2B3F7F131A4F72 ON manifestation (commune_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE manifestation_commune (manifestation_id INT NOT NULL, commune_id INT NOT NULL, PRIMARY KEY(manifestation_id, commune_id))');
        $this->addSql('CREATE INDEX idx_cbf8737d131a4f72 ON manifestation_commune (commune_id)');
        $this->addSql('CREATE INDEX idx_cbf8737dcd8e394e ON manifestation_commune (manifestation_id)');
        $this->addSql('ALTER TABLE manifestation_commune ADD CONSTRAINT fk_cbf8737dcd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_commune ADD CONSTRAINT fk_cbf8737d131a4f72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation DROP CONSTRAINT FK_6F2B3F7F131A4F72');
        $this->addSql('DROP INDEX IDX_6F2B3F7F131A4F72');
        $this->addSql('ALTER TABLE manifestation RENAME COLUMN commune_id TO staedte_id');
        $this->addSql('ALTER TABLE manifestation ADD CONSTRAINT fk_6f2b3f7f9cbb1703 FOREIGN KEY (staedte_id) REFERENCES staedte (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6f2b3f7f9cbb1703 ON manifestation (staedte_id)');
    }
}
