<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240507152142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE type_project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE type_project (id INT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE project ADD type_project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD status_project_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project DROP statut');
        $this->addSql('ALTER TABLE project DROP type');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEB6EC9B9 FOREIGN KEY (type_project_id) REFERENCES type_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE173EFB1A FOREIGN KEY (status_project_id) REFERENCES status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEB6EC9B9 ON project (type_project_id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE173EFB1A ON project (status_project_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EEB6EC9B9');
        $this->addSql('DROP SEQUENCE type_project_id_seq CASCADE');
        $this->addSql('DROP TABLE type_project');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE173EFB1A');
        $this->addSql('DROP INDEX IDX_2FB3D0EEB6EC9B9');
        $this->addSql('DROP INDEX IDX_2FB3D0EE173EFB1A');
        $this->addSql('ALTER TABLE project ADD statut VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE project DROP type_project_id');
        $this->addSql('ALTER TABLE project DROP status_project_id');
    }
}
