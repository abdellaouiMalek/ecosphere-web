<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240306200125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_rating (id INT AUTO_INCREMENT NOT NULL, event_id INT NOT NULL, rating INT DEFAULT NULL, INDEX IDX_EA10517071F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE event_rating ADD CONSTRAINT FK_EA10517071F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE carpooling CHANGE departure_date departure_date DATE NOT NULL, CHANGE arrival_date arrival_date DATE NOT NULL, CHANGE destination destination VARCHAR(255) NOT NULL, CHANGE departure departure VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE time time TIME NOT NULL');
        $this->addSql('ALTER TABLE event ADD category_id INT DEFAULT NULL, ADD active TINYINT(1) DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA712469DE2 ON event (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA712469DE2');
        $this->addSql('ALTER TABLE event_rating DROP FOREIGN KEY FK_EA10517071F7E88B');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE event_rating');
        $this->addSql('ALTER TABLE carpooling CHANGE departure_date departure_date DATE DEFAULT NULL, CHANGE arrival_date arrival_date DATE DEFAULT NULL, CHANGE departure departure VARCHAR(255) DEFAULT NULL, CHANGE destination destination VARCHAR(255) DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE time time TIME DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_3BAE0AA712469DE2 ON event');
        $this->addSql('ALTER TABLE event DROP category_id, DROP active, CHANGE description description VARCHAR(255) NOT NULL');
    }
}
