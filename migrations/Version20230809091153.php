<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230809091153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact ADD user_id INT DEFAULT NULL, DROP user');
        $this->addSql('ALTER TABLE formulaire_contact ADD CONSTRAINT FK_69601E3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_69601E3A76ED395 ON formulaire_contact (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formulaire_contact DROP FOREIGN KEY FK_69601E3A76ED395');
        $this->addSql('DROP INDEX IDX_69601E3A76ED395 ON formulaire_contact');
        $this->addSql('ALTER TABLE formulaire_contact ADD user LONGTEXT DEFAULT NULL, DROP user_id');
    }
}
