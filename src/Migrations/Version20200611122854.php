<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200611122854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE owners_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE plants_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE owners (id INT NOT NULL, name VARCHAR(255) NOT NULL, country VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE owners_plants (owners_id INT NOT NULL, plants_id INT NOT NULL, PRIMARY KEY(owners_id, plants_id))');
        $this->addSql('CREATE INDEX IDX_7E32CA53236ECBFC ON owners_plants (owners_id)');
        $this->addSql('CREATE INDEX IDX_7E32CA5362091EAB ON owners_plants (plants_id)');
        $this->addSql('CREATE TABLE plants (id INT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, capacity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE owners_plants ADD CONSTRAINT FK_7E32CA53236ECBFC FOREIGN KEY (owners_id) REFERENCES owners (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE owners_plants ADD CONSTRAINT FK_7E32CA5362091EAB FOREIGN KEY (plants_id) REFERENCES plants (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE owners_plants DROP CONSTRAINT FK_7E32CA53236ECBFC');
        $this->addSql('ALTER TABLE owners_plants DROP CONSTRAINT FK_7E32CA5362091EAB');
        $this->addSql('DROP SEQUENCE owners_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE plants_id_seq CASCADE');
        $this->addSql('DROP TABLE owners');
        $this->addSql('DROP TABLE owners_plants');
        $this->addSql('DROP TABLE plants');
    }
}
