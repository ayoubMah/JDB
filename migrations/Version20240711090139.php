<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711090139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, body CLOB NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Admin AS SELECT id, username, password FROM Admin');
        $this->addSql('DROP TABLE Admin');
        $this->addSql('CREATE TABLE Admin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO Admin (id, username, password) SELECT id, username, password FROM __temp__Admin');
        $this->addSql('DROP TABLE __temp__Admin');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Stagiaire AS SELECT id, nom, prenom, email, admin_id, login, password FROM Stagiaire');
        $this->addSql('DROP TABLE Stagiaire');
        $this->addSql('CREATE TABLE Stagiaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, admin_id INTEGER NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO Stagiaire (id, nom, prenom, email, admin_id, login, password) SELECT id, nom, prenom, email, admin_id, login, password FROM __temp__Stagiaire');
        $this->addSql('DROP TABLE __temp__Stagiaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F62F731AA08CB10 ON Stagiaire (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TEMPORARY TABLE __temp__admin AS SELECT id, username, password FROM admin');
        $this->addSql('DROP TABLE admin');
        $this->addSql('CREATE TABLE admin (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, username CLOB NOT NULL, password CLOB NOT NULL)');
        $this->addSql('INSERT INTO admin (id, username, password) SELECT id, username, password FROM __temp__admin');
        $this->addSql('DROP TABLE __temp__admin');
        $this->addSql('CREATE TEMPORARY TABLE __temp__stagiaire AS SELECT id, nom, prenom, email, admin_id, login, password FROM stagiaire');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('CREATE TABLE stagiaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, admin_id INTEGER NOT NULL, login VARCHAR(255) DEFAULT NULL, password VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO stagiaire (id, nom, prenom, email, admin_id, login, password) SELECT id, nom, prenom, email, admin_id, login, password FROM __temp__stagiaire');
        $this->addSql('DROP TABLE __temp__stagiaire');
        $this->addSql('CREATE UNIQUE INDEX unique_login ON stagiaire (login)');
    }
}
