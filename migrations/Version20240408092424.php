<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240408092424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu_manifestation DROP CONSTRAINT fk_e9799fe46ab213cc');
        $this->addSql('ALTER TABLE lieu_manifestation DROP CONSTRAINT fk_e9799fe4cd8e394e');
        $this->addSql('DROP TABLE lieu_manifestation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE lieu_manifestation (lieu_id INT NOT NULL, manifestation_id INT NOT NULL, PRIMARY KEY(lieu_id, manifestation_id))');
        $this->addSql('CREATE INDEX idx_e9799fe4cd8e394e ON lieu_manifestation (manifestation_id)');
        $this->addSql('CREATE INDEX idx_e9799fe46ab213cc ON lieu_manifestation (lieu_id)');
        $this->addSql('ALTER TABLE lieu_manifestation ADD CONSTRAINT fk_e9799fe46ab213cc FOREIGN KEY (lieu_id) REFERENCES lieu (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lieu_manifestation ADD CONSTRAINT fk_e9799fe4cd8e394e FOREIGN KEY (manifestation_id) REFERENCES manifestation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
