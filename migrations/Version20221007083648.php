<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007083648 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures ADD newsletter TINYINT(1) NOT NULL, ADD promote TINYINT(1) NOT NULL, ADD planning TINYINT(1) NOT NULL, ADD products TINYINT(1) NOT NULL, ADD digicode TINYINT(1) NOT NULL, ADD statistics TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures DROP newsletter, DROP promote, DROP planning, DROP products, DROP digicode, DROP statistics');
    }
}
