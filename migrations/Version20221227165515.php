<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227165515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE certification (id INT AUTO_INCREMENT NOT NULL, type_certif_id INT NOT NULL, session_certif_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_6C3C6D7557016914 (type_certif_id), INDEX IDX_6C3C6D75A0256D0E (session_certif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, iduser_id INT NOT NULL, matricule VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, sexe VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, cin VARCHAR(10) DEFAULT NULL, passeport INT DEFAULT NULL, specialite VARCHAR(255) NOT NULL, INDEX IDX_81A72FA1786A81FB (iduser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, iduser_id INT DEFAULT NULL, filiere_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, date_n DATE NOT NULL, sexe VARCHAR(255) NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, cin VARCHAR(10) DEFAULT NULL, passeport VARCHAR(255) DEFAULT NULL, tel_parent INT NOT NULL, email_parent VARCHAR(255) DEFAULT NULL, etat_civil VARCHAR(255) DEFAULT NULL, INDEX IDX_717E22E3786A81FB (iduser_id), INDEX IDX_717E22E3180AA129 (filiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_certif (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_certif (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, email VARCHAR(255) NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone INT DEFAULT NULL, actif TINYINT(1) NOT NULL, INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_certif (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, certif_id INT NOT NULL, demande INT NOT NULL, resultat INT DEFAULT NULL, INDEX IDX_8902834FA76ED395 (user_id), INDEX IDX_8902834FE3C72804 (certif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D7557016914 FOREIGN KEY (type_certif_id) REFERENCES type_certif (id)');
        $this->addSql('ALTER TABLE certification ADD CONSTRAINT FK_6C3C6D75A0256D0E FOREIGN KEY (session_certif_id) REFERENCES session_certif (id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
        $this->addSql('ALTER TABLE user_certif ADD CONSTRAINT FK_8902834FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_certif ADD CONSTRAINT FK_8902834FE3C72804 FOREIGN KEY (certif_id) REFERENCES certification (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D7557016914');
        $this->addSql('ALTER TABLE certification DROP FOREIGN KEY FK_6C3C6D75A0256D0E');
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1786A81FB');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3786A81FB');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3180AA129');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE user_certif DROP FOREIGN KEY FK_8902834FA76ED395');
        $this->addSql('ALTER TABLE user_certif DROP FOREIGN KEY FK_8902834FE3C72804');
        $this->addSql('DROP TABLE certification');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE session_certif');
        $this->addSql('DROP TABLE type_certif');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_certif');
    }
}
