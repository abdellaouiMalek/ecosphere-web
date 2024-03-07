<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306201545 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, carpooling_id INT DEFAULT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C84955AFB2200A (carpooling_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955AFB2200A FOREIGN KEY (carpooling_id) REFERENCES carpooling (id)');
        $this->addSql('ALTER TABLE carpooling ADD departure VARCHAR(255) NOT NULL, ADD destination VARCHAR(255) NOT NULL, DROP daparture_place, DROP arrival_place, CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD phone_number VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955AFB2200A');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE carpooling ADD daparture_place VARCHAR(255) NOT NULL, ADD arrival_place VARCHAR(255) NOT NULL, DROP departure, DROP destination, CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP phone_number');
    }
}
