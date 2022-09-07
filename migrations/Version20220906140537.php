<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906140537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions ADD name VARCHAR(50) NOT NULL, DROP newsletter, DROP planning, DROP promote, DROP sell_products, DROP statistics, DROP evenements, DROP digicode');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions ADD newsletter TINYINT(1) NOT NULL, ADD planning TINYINT(1) NOT NULL, ADD promote TINYINT(1) NOT NULL, ADD sell_products TINYINT(1) NOT NULL, ADD statistics TINYINT(1) NOT NULL, ADD evenements TINYINT(1) NOT NULL, ADD digicode TINYINT(1) NOT NULL, DROP name');
    }
}
