<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240201164244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exchange_rate (id INT AUTO_INCREMENT NOT NULL, source VARCHAR(3) NOT NULL, target VARCHAR(3) NOT NULL, rate NUMERIC(16, 8) NOT NULL, provider VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, UNIQUE INDEX exchange_rate_unique (source, target, provider), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usd_rate (id INT AUTO_INCREMENT NOT NULL, currency VARCHAR(3) NOT NULL, rate NUMERIC(16, 8) NOT NULL, timestamp DATETIME NOT NULL, UNIQUE INDEX currency_unique (currency), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE exchange_rate');
        $this->addSql('DROP TABLE usd_rate');
    }
}
