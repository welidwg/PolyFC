<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221226225723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, iduser_id INT DEFAULT NULL, matricule VARCHAR(255) NOT NULL, date_n DATE NOT NULL, sexe VARCHAR(255) NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, cin VARCHAR(10) DEFAULT NULL, passeport VARCHAR(255) DEFAULT NULL, tel_parent VARCHAR(8) NOT NULL, email_parent VARCHAR(255) DEFAULT NULL, etat_civil VARCHAR(255) DEFAULT NULL, INDEX IDX_717E22E3786A81FB (iduser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3786A81FB');
        $this->addSql('DROP TABLE etudiant');
    }
}
