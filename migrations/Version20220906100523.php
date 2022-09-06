<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906100523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures ADD permission_newsletter TINYINT(1) NOT NULL, ADD permission_planning TINYINT(1) NOT NULL, ADD permission_promote TINYINT(1) NOT NULL, ADD permission_products TINYINT(1) NOT NULL, ADD permission_statistics TINYINT(1) NOT NULL, ADD permission_evenements TINYINT(1) NOT NULL, ADD permission_digicode TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures DROP permission_newsletter, DROP permission_planning, DROP permission_promote, DROP permission_products, DROP permission_statistics, DROP permission_evenements, DROP permission_digicode');
    }
}
