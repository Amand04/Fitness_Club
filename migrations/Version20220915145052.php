<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915145052 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners CHANGE active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE permissions CHANGE active active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE structures CHANGE active active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions CHANGE active active VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE structures CHANGE active active VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE partners CHANGE active active VARCHAR(30) NOT NULL');
    }
}
