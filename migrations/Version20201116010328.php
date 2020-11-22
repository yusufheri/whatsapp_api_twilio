<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116010328 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, content LONGTEXT DEFAULT NULL, updated_at DATETIME DEFAULT NULL, media VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `group` (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, favorite_id INT NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(255) DEFAULT NULL, sent_at DATE DEFAULT NULL, state TINYINT(1) DEFAULT NULL, INDEX IDX_B6BD307F217BBB47 (person_id), INDEX IDX_B6BD307FAA17481D (favorite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, created_at DATETIME NOT NULL, name VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, phone_main VARCHAR(15) NOT NULL, phone_second VARCHAR(15) DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_34DCD1767A45358C (groupe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FAA17481D FOREIGN KEY (favorite_id) REFERENCES favorite (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1767A45358C FOREIGN KEY (groupe_id) REFERENCES `group` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FAA17481D');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1767A45358C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F217BBB47');
        $this->addSql('DROP TABLE favorite');
        $this->addSql('DROP TABLE `group`');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE person');
    }
}
