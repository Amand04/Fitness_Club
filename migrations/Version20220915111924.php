<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915111924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions ADD structures_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE permissions ADD CONSTRAINT FK_2DEDCC6F9D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id)');
        $this->addSql('CREATE INDEX IDX_2DEDCC6F9D3ED38D ON permissions (structures_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE permissions DROP FOREIGN KEY FK_2DEDCC6F9D3ED38D');
        $this->addSql('DROP INDEX IDX_2DEDCC6F9D3ED38D ON permissions');
        $this->addSql('ALTER TABLE permissions DROP structures_id');
    }
}
