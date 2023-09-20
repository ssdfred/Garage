<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920092054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE formulaire_contact (id INT AUTO_INCREMENT NOT NULL, voiture_id INT DEFAULT NULL, user_id INT DEFAULT NULL, sujet LONGTEXT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, numero_telephone VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, INDEX IDX_69601E3181A8BA (voiture_id), INDEX IDX_69601E3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE horaire (id INT AUTO_INCREMENT NOT NULL, jour_semaine VARCHAR(255) NOT NULL, heure_ouverture TIME NOT NULL, heure_fermeture TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temoignage (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, commentaire LONGTEXT NOT NULL, note INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_BDADBC46A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(55) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix NUMERIC(10, 2) NOT NULL, image VARCHAR(255) NOT NULL, annee_mise_circulation DATE NOT NULL, kilometrage INT NOT NULL, galerie_images LONGTEXT DEFAULT NULL, caracteristiques LONGTEXT NOT NULL, equipements_options LONGTEXT NOT NULL, INDEX IDX_E9E2810FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE formulaire_contact ADD CONSTRAINT FK_69601E3181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE formulaire_contact ADD CONSTRAINT FK_69601E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE temoignage ADD CONSTRAINT FK_BDADBC46A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE voiture ADD CONSTRAINT FK_E9E2810FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact DROP FOREIGN KEY FK_69601E3181A8BA');
        $this->addSql('ALTER TABLE formulaire_contact DROP FOREIGN KEY FK_69601E3A76ED395');
        $this->addSql('ALTER TABLE temoignage DROP FOREIGN KEY FK_BDADBC46A76ED395');
        $this->addSql('ALTER TABLE voiture DROP FOREIGN KEY FK_E9E2810FA76ED395');
        $this->addSql('DROP TABLE formulaire_contact');
        $this->addSql('DROP TABLE horaire');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE temoignage');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE voiture');
    }
}
