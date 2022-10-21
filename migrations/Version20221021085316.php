<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221021085316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street_name VARCHAR(255) NOT NULL, street_number VARCHAR(30) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(15) NOT NULL, voivodeship VARCHAR(100) NOT NULL, phone VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, pesel VARCHAR(15) DEFAULT NULL, nip VARCHAR(15) DEFAULT NULL, is_individual_client BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clients');
    }
}
