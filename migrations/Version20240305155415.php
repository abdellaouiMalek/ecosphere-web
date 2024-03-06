<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305155415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carpooling ADD passenger_id VARCHAR(255) DEFAULT NULL, CHANGE departure_date departure_date DATE NOT NULL, CHANGE arrival_date arrival_date DATE NOT NULL, CHANGE destination destination VARCHAR(255) NOT NULL, CHANGE departure departure VARCHAR(255) NOT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE time time TIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carpooling DROP passenger_id, CHANGE departure_date departure_date DATE DEFAULT NULL, CHANGE arrival_date arrival_date DATE DEFAULT NULL, CHANGE departure departure VARCHAR(255) DEFAULT NULL, CHANGE destination destination VARCHAR(255) DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL, CHANGE time time TIME DEFAULT NULL');
    }
}
