<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221022201436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, street_name VARCHAR(255) NOT NULL, street_number VARCHAR(30) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(15) NOT NULL, voivodeship VARCHAR(100) NOT NULL, phone VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, pesel VARCHAR(15) DEFAULT NULL, nip VARCHAR(15) DEFAULT NULL, is_individual_client BOOLEAN NOT NULL, area_code VARCHAR(16) NOT NULL)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9F85E0677 ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE users');
    }
}
