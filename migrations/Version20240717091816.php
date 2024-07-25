<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240717091816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__etudiant AS SELECT id, nom, prénom, login, email FROM etudiant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('CREATE TABLE etudiant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prénom VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO etudiant (id, nom, prénom, login, email) SELECT id, nom, prénom, login, email FROM __temp__etudiant');
        $this->addSql('DROP TABLE __temp__etudiant');
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
        $this->addSql('CREATE TEMPORARY TABLE __temp__stagiaire AS SELECT id, login, password, nom, prenom, email, admin_id FROM stagiaire');
        $this->addSql('DROP TABLE stagiaire');
        $this->addSql('CREATE TABLE stagiaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, admin_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO stagiaire (id, login, password, nom, prenom, email, admin_id) SELECT id, login, password, nom, prenom, email, admin_id FROM __temp__stagiaire');
        $this->addSql('DROP TABLE __temp__stagiaire');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4F62F731AA08CB10 ON stagiaire (login)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__etudiant AS SELECT id, nom, prénom, login, email FROM etudiant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('CREATE TABLE etudiant (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(100) DEFAULT NULL, prénom VARCHAR(100) DEFAULT NULL, login VARCHAR(100) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO etudiant (id, nom, prénom, login, email) SELECT id, nom, prénom, login, email FROM __temp__etudiant');
        $this->addSql('DROP TABLE __temp__etudiant');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E3AA08CB10 ON etudiant (login)');
    }
}
