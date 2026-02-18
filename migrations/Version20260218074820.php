<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260218074820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE wish CHANGE title title VARCHAR(250) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE author author VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT FK_D7D174C912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE name name VARCHAR(50) NOT NULL COLLATE `utf8mb4_0900_ai_ci`');
        $this->addSql('ALTER TABLE wish DROP FOREIGN KEY FK_D7D174C912469DE2');
        $this->addSql('ALTER TABLE wish CHANGE title title VARCHAR(250) NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_0900_ai_ci`, CHANGE author author VARCHAR(50) NOT NULL COLLATE `utf8mb4_0900_ai_ci`');
    }
}
