<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213093623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish CHANGE title title VARCHAR(250) NOT NULL, CHANGE author author VARCHAR(50) NOT NULL, CHANGE is_published is_published TINYINT NOT NULL, CHANGE date_created date_created DATETIME NOT NULL, CHANGE date_updated date_updated DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish CHANGE title title VARCHAR(250) DEFAULT NULL, CHANGE author author VARCHAR(50) DEFAULT NULL, CHANGE is_published is_published TINYINT DEFAULT NULL, CHANGE date_created date_created DATETIME DEFAULT NULL, CHANGE date_updated date_updated DATETIME NOT NULL');
    }
}
