<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927092151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions ADD CONSTRAINT FK_2DEDCC6FBDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partners (id)');
        $this->addSql('CREATE INDEX IDX_2DEDCC6FBDE7F1C6 ON permissions (partners_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions DROP FOREIGN KEY FK_2DEDCC6FBDE7F1C6');
        $this->addSql('DROP INDEX IDX_2DEDCC6FBDE7F1C6 ON permissions');
    }
}
