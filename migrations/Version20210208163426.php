<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208163426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person ADD sid VARCHAR(255) DEFAULT NULL, ADD date_created_sms VARCHAR(255) DEFAULT NULL, ADD date_updated_sms VARCHAR(255) DEFAULT NULL, ADD valid TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD fullname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP sid, DROP date_created_sms, DROP date_updated_sms, DROP valid');
        $this->addSql('ALTER TABLE user DROP fullname');
    }
}
