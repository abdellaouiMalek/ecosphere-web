<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240301182848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE historique (id INT AUTO_INCREMENT NOT NULL, objet_id INT DEFAULT NULL, nom_o VARCHAR(255) NOT NULL, initial_condition VARCHAR(255) NOT NULL, date DATE NOT NULL, INDEX IDX_EDBFD5ECF520CF5A (objet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, upload VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, historique VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, nom_o VARCHAR(255) DEFAULT NULL, prix INT DEFAULT NULL, history VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECF520CF5A');
        $this->addSql('DROP TABLE historique');
        $this->addSql('DROP TABLE objet');
    }
}
