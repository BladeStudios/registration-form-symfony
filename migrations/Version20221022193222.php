<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022193222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE clients ADD COLUMN area_code VARCHAR(16) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__clients AS SELECT id, name, street_name, street_number, city, postal_code, voivodeship, phone, email, pesel, nip, is_individual_client FROM clients');
        $this->addSql('DROP TABLE clients');
        $this->addSql('CREATE TABLE clients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street_name VARCHAR(255) NOT NULL, street_number VARCHAR(30) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(15) NOT NULL, voivodeship VARCHAR(100) NOT NULL, phone VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, pesel VARCHAR(15) DEFAULT NULL, nip VARCHAR(15) DEFAULT NULL, is_individual_client BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO clients (id, name, street_name, street_number, city, postal_code, voivodeship, phone, email, pesel, nip, is_individual_client) SELECT id, name, street_name, street_number, city, postal_code, voivodeship, phone, email, pesel, nip, is_individual_client FROM __temp__clients');
        $this->addSql('DROP TABLE __temp__clients');
    }
}
