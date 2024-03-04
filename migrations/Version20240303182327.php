<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303182327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reaction_id INT DEFAULT NULL, comment_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, pub_date DATE NOT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_BA5AE01DA76ED395 (user_id), UNIQUE INDEX UNIQ_BA5AE01D813C7171 (reaction_id), UNIQUE INDEX UNIQ_BA5AE01DF8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carpooling (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, carpooling_request_id INT DEFAULT NULL, departure_date DATE NOT NULL, arrival_date DATE NOT NULL, daparture_place VARCHAR(255) NOT NULL, arrival_place VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, time TIME NOT NULL, INDEX IDX_6CC153F1A76ED395 (user_id), UNIQUE INDEX UNIQ_6CC153F113A36FC5 (carpooling_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carpooling_request (id INT AUTO_INCREMENT NOT NULL, daparture_date DATE NOT NULL, arrival_date DATE NOT NULL, departure_place VARCHAR(255) NOT NULL, destination VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, pub_date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, event_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, date DATE NOT NULL, time TIME NOT NULL, location VARCHAR(255) NOT NULL, objective VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_registrations (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, event_id INT DEFAULT NULL, registration_date DATE NOT NULL, registration_time TIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_7787E14BA76ED395 (user_id), INDEX IDX_7787E14B71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, innitial_condition VARCHAR(255) NOT NULL, arrival_state VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reusable_object (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, history_id INT NOT NULL, type VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, age INT NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_2F9EC7C6A76ED395 (user_id), UNIQUE INDEX UNIQ_2F9EC7C61E058452 (history_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, user_name VARCHAR(255) NOT NULL, user_rating INT NOT NULL, user_review LONGTEXT DEFAULT NULL, INDEX IDX_6970EB0F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, store_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store_product (store_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_CA42254AB092A811 (store_id), INDEX IDX_CA42254A4584665A (product_id), PRIMARY KEY(store_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number DOUBLE PRECISION NOT NULL, picture VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_store (user_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_1D95A32FA76ED395 (user_id), INDEX IDX_1D95A32FB092A811 (store_id), PRIMARY KEY(user_id, store_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_event (user_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_D96CF1FFA76ED395 (user_id), INDEX IDX_D96CF1FF71F7E88B (event_id), PRIMARY KEY(user_id, event_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01D813C7171 FOREIGN KEY (reaction_id) REFERENCES reaction (id)');
        $this->addSql('ALTER TABLE blog_post ADD CONSTRAINT FK_BA5AE01DF8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE carpooling ADD CONSTRAINT FK_6CC153F1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE carpooling ADD CONSTRAINT FK_6CC153F113A36FC5 FOREIGN KEY (carpooling_request_id) REFERENCES carpooling_request (id)');
        $this->addSql('ALTER TABLE event_registrations ADD CONSTRAINT FK_7787E14BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE event_registrations ADD CONSTRAINT FK_7787E14B71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE reusable_object ADD CONSTRAINT FK_2F9EC7C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reusable_object ADD CONSTRAINT FK_2F9EC7C61E058452 FOREIGN KEY (history_id) REFERENCES history (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F71F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE store_product ADD CONSTRAINT FK_CA42254AB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE store_product ADD CONSTRAINT FK_CA42254A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_store ADD CONSTRAINT FK_1D95A32FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_store ADD CONSTRAINT FK_1D95A32FB092A811 FOREIGN KEY (store_id) REFERENCES store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_event ADD CONSTRAINT FK_D96CF1FF71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01DA76ED395');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01D813C7171');
        $this->addSql('ALTER TABLE blog_post DROP FOREIGN KEY FK_BA5AE01DF8697D13');
        $this->addSql('ALTER TABLE carpooling DROP FOREIGN KEY FK_6CC153F1A76ED395');
        $this->addSql('ALTER TABLE carpooling DROP FOREIGN KEY FK_6CC153F113A36FC5');
        $this->addSql('ALTER TABLE event_registrations DROP FOREIGN KEY FK_7787E14BA76ED395');
        $this->addSql('ALTER TABLE event_registrations DROP FOREIGN KEY FK_7787E14B71F7E88B');
        $this->addSql('ALTER TABLE reusable_object DROP FOREIGN KEY FK_2F9EC7C6A76ED395');
        $this->addSql('ALTER TABLE reusable_object DROP FOREIGN KEY FK_2F9EC7C61E058452');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F71F7E88B');
        $this->addSql('ALTER TABLE store_product DROP FOREIGN KEY FK_CA42254AB092A811');
        $this->addSql('ALTER TABLE store_product DROP FOREIGN KEY FK_CA42254A4584665A');
        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FA76ED395');
        $this->addSql('ALTER TABLE user_store DROP FOREIGN KEY FK_1D95A32FB092A811');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FFA76ED395');
        $this->addSql('ALTER TABLE user_event DROP FOREIGN KEY FK_D96CF1FF71F7E88B');
        $this->addSql('DROP TABLE blog_post');
        $this->addSql('DROP TABLE carpooling');
        $this->addSql('DROP TABLE carpooling_request');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_registrations');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE reusable_object');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE store');
        $this->addSql('DROP TABLE store_product');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_store');
        $this->addSql('DROP TABLE user_event');
    }
}
