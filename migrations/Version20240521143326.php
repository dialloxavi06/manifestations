<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521143326 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE manifestation_staedte (manifestation_id INT NOT NULL, staedte_id INT NOT NULL, PRIMARY KEY(manifestation_id, staedte_id))');
        $this->addSql('CREATE INDEX IDX_68BAEB99CD8E394E ON manifestation_staedte (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_68BAEB999CBB1703 ON manifestation_staedte (staedte_id)');
        $this->addSql('CREATE TABLE manifestation_commune (manifestation_id INT NOT NULL, commune_id INT NOT NULL, PRIMARY KEY(manifestation_id, commune_id))');
        $this->addSql('CREATE INDEX IDX_CBF8737DCD8E394E ON manifestation_commune (manifestation_id)');
        $this->addSql('CREATE INDEX IDX_CBF8737D131A4F72 ON manifestation_commune (commune_id)');
        $this->addSql('ALTER TABLE manifestation_staedte ADD CONSTRAINT FK_68BAEB99CD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_staedte ADD CONSTRAINT FK_68BAEB999CBB1703 FOREIGN KEY (staedte_id) REFERENCES staedte (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_commune ADD CONSTRAINT FK_CBF8737DCD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_commune ADD CONSTRAINT FK_CBF8737D131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE staedte_manifestation DROP CONSTRAINT fk_47644cbe9cbb1703');
        $this->addSql('ALTER TABLE staedte_manifestation DROP CONSTRAINT fk_47644cbecd8e394e');
        $this->addSql('ALTER TABLE commune_manifestation DROP CONSTRAINT fk_abcf06e8131a4f72');
        $this->addSql('ALTER TABLE commune_manifestation DROP CONSTRAINT fk_abcf06e8cd8e394e');
        $this->addSql('DROP TABLE staedte_manifestation');
        $this->addSql('DROP TABLE commune_manifestation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE staedte_manifestation (staedte_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(staedte_id, manifestation_id))');
        $this->addSql('CREATE INDEX idx_47644cbecd8e394e ON staedte_manifestation (manifestation_id)');
        $this->addSql('CREATE INDEX idx_47644cbe9cbb1703 ON staedte_manifestation (staedte_id)');
        $this->addSql('CREATE TABLE commune_manifestation (commune_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(commune_id, manifestation_id))');
        $this->addSql('CREATE INDEX idx_abcf06e8cd8e394e ON commune_manifestation (manifestation_id)');
        $this->addSql('CREATE INDEX idx_abcf06e8131a4f72 ON commune_manifestation (commune_id)');
        $this->addSql('ALTER TABLE staedte_manifestation ADD CONSTRAINT fk_47644cbe9cbb1703 FOREIGN KEY (staedte_id) REFERENCES staedte (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE staedte_manifestation ADD CONSTRAINT fk_47644cbecd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commune_manifestation ADD CONSTRAINT fk_abcf06e8131a4f72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commune_manifestation ADD CONSTRAINT fk_abcf06e8cd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE manifestation_staedte DROP CONSTRAINT FK_68BAEB99CD8E394E');
        $this->addSql('ALTER TABLE manifestation_staedte DROP CONSTRAINT FK_68BAEB999CBB1703');
        $this->addSql('ALTER TABLE manifestation_commune DROP CONSTRAINT FK_CBF8737DCD8E394E');
        $this->addSql('ALTER TABLE manifestation_commune DROP CONSTRAINT FK_CBF8737D131A4F72');
        $this->addSql('DROP TABLE manifestation_staedte');
        $this->addSql('DROP TABLE manifestation_commune');
    }
}
