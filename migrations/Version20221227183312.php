<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221227183312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enseignant (id INT AUTO_INCREMENT NOT NULL, iduser_id INT NOT NULL, matricule VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, sexe VARCHAR(255) NOT NULL, addresse VARCHAR(255) NOT NULL, cin VARCHAR(10) DEFAULT NULL, passeport INT DEFAULT NULL, specialite VARCHAR(255) NOT NULL, INDEX IDX_81A72FA1786A81FB (iduser_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, id_certif_id INT NOT NULL, libelle_formation VARCHAR(255) NOT NULL, INDEX IDX_404021BF63F29423 (id_certif_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_enseignant (formation_id INT NOT NULL, enseignant_id INT NOT NULL, INDEX IDX_790FFC985200282E (formation_id), INDEX IDX_790FFC98E455FCC0 (enseignant_id), PRIMARY KEY(formation_id, enseignant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT FK_81A72FA1786A81FB FOREIGN KEY (iduser_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF63F29423 FOREIGN KEY (id_certif_id) REFERENCES certification (id)');
        $this->addSql('ALTER TABLE formation_enseignant ADD CONSTRAINT FK_790FFC985200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_enseignant ADD CONSTRAINT FK_790FFC98E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enseignant DROP FOREIGN KEY FK_81A72FA1786A81FB');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF63F29423');
        $this->addSql('ALTER TABLE formation_enseignant DROP FOREIGN KEY FK_790FFC985200282E');
        $this->addSql('ALTER TABLE formation_enseignant DROP FOREIGN KEY FK_790FFC98E455FCC0');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_enseignant');
    }
}
