<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906115630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures ADD lastname VARCHAR(50) NOT NULL, ADD firstname VARCHAR(50) NOT NULL, CHANGE adress adress VARCHAR(100) NOT NULL, CHANGE permission_newsletter permission_newsletter TINYINT(1) NOT NULL, CHANGE permission_planning permission_planning TINYINT(1) NOT NULL, CHANGE permission_promote permission_promote TINYINT(1) NOT NULL, CHANGE permission_products permission_products TINYINT(1) NOT NULL, CHANGE permission_statistics permission_statistics TINYINT(1) NOT NULL, CHANGE permission_evenements permission_evenements TINYINT(1) NOT NULL, CHANGE permission_digicode permission_digicode TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures DROP lastname, DROP firstname, CHANGE adress adress VARCHAR(70) NOT NULL, CHANGE permission_newsletter permission_newsletter TINYINT(1) DEFAULT 1 NOT NULL, CHANGE permission_planning permission_planning TINYINT(1) DEFAULT 1 NOT NULL, CHANGE permission_promote permission_promote TINYINT(1) DEFAULT 1 NOT NULL, CHANGE permission_products permission_products TINYINT(1) DEFAULT 1 NOT NULL, CHANGE permission_statistics permission_statistics TINYINT(1) DEFAULT 1 NOT NULL, CHANGE permission_evenements permission_evenements TINYINT(1) DEFAULT 1 NOT NULL, CHANGE permission_digicode permission_digicode TINYINT(1) DEFAULT 1 NOT NULL');
    }
}
