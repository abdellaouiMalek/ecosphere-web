<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240220145307 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE objet (id INT AUTO_INCREMENT NOT NULL, id_o VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, age INT NOT NULL, history VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, type_o VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE historique ADD objet_id INT DEFAULT NULL, ADD id_h VARCHAR(255) NOT NULL, ADD initial_condition VARCHAR(255) NOT NULL, ADD arrival_state VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE historique ADD CONSTRAINT FK_EDBFD5ECF520CF5A FOREIGN KEY (objet_id) REFERENCES objet (id)');
        $this->addSql('CREATE INDEX IDX_EDBFD5ECF520CF5A ON historique (objet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE historique DROP FOREIGN KEY FK_EDBFD5ECF520CF5A');
        $this->addSql('DROP TABLE objet');
        $this->addSql('DROP INDEX IDX_EDBFD5ECF520CF5A ON historique');
        $this->addSql('ALTER TABLE historique DROP objet_id, DROP id_h, DROP initial_condition, DROP arrival_state');
    }
}
