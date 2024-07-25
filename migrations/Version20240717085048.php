<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717085048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prénom VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, body CLOB NOT NULL)');
        $this->addSql('DROP TABLE étudiant');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Stagiaire AS SELECT id, nom, prenom, email, admin_id, login, password FROM Stagiaire');
        $this->addSql('DROP TABLE Stagiaire');
        $this->addSql('CREATE TABLE Stagiaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, admin_id INTEGER NOT NULL, login VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO Stagiaire (id, nom, prenom, email, admin_id, login, password) SELECT id, nom, prenom, email, admin_id, login, password FROM __temp__Stagiaire');
        $this->addSql('DROP TABLE __temp__Stagiaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F62F731AA08CB10 ON Stagiaire (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE étudiant (id INTEGER PRIMARY KEY AUTOINCREMENT DEFAULT NULL, nom CLOB NOT NULL COLLATE "BINARY", prénom CLOB NOT NULL COLLATE "BINARY", login CLOB NOT NULL COLLATE "BINARY", email CLOB NOT NULL COLLATE "BINARY")');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TEMPORARY TABLE __temp__stagiaire AS SELECT id, login, password, nom, prenom, email, admin_id FROM stagiaire');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('CREATE TABLE stagiaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, admin_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO stagiaire (id, login, password, nom, prenom, email, admin_id) SELECT id, login, password, nom, prenom, email, admin_id FROM __temp__stagiaire');
        $this->addSql('DROP TABLE __temp__stagiaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F62F731AA08CB10 ON stagiaire (login)');
    }
}
