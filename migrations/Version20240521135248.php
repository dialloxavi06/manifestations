<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521135248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commune_manifestation (commune_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(commune_id, manifestation_id))');
        $this->addSql('CREATE INDEX IDX_ABCF06E8131A4F72 ON commune_manifestation (commune_id)');
        $this->addSql('CREATE INDEX IDX_ABCF06E8CD8E394E ON commune_manifestation (manifestation_id)');
        $this->addSql('CREATE TABLE staedte_manifestation (staedte_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(staedte_id, manifestation_id))');
        $this->addSql('CREATE INDEX IDX_47644CBE9CBB1703 ON staedte_manifestation (staedte_id)');
        $this->addSql('CREATE INDEX IDX_47644CBECD8E394E ON staedte_manifestation (manifestation_id)');
        $this->addSql('ALTER TABLE commune_manifestation ADD CONSTRAINT FK_ABCF06E8131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commune_manifestation ADD CONSTRAINT FK_ABCF06E8CD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE staedte_manifestation ADD CONSTRAINT FK_47644CBE9CBB1703 FOREIGN KEY (staedte_id) REFERENCES staedte (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE staedte_manifestation ADD CONSTRAINT FK_47644CBECD8E394E FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE commune_manifestation DROP CONSTRAINT FK_ABCF06E8131A4F72');
        $this->addSql('ALTER TABLE commune_manifestation DROP CONSTRAINT FK_ABCF06E8CD8E394E');
        $this->addSql('ALTER TABLE staedte_manifestation DROP CONSTRAINT FK_47644CBE9CBB1703');
        $this->addSql('ALTER TABLE staedte_manifestation DROP CONSTRAINT FK_47644CBECD8E394E');
        $this->addSql('DROP TABLE commune_manifestation');
        $this->addSql('DROP TABLE staedte_manifestation');
    }
}
