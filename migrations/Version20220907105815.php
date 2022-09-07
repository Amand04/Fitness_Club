<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907105815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE structures_permissions (structures_id INT NOT NULL, permissions_id INT NOT NULL, INDEX IDX_15DA28EF9D3ED38D (structures_id), INDEX IDX_15DA28EF9C3E4F87 (permissions_id), PRIMARY KEY(structures_id, permissions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE structures_permissions ADD CONSTRAINT FK_15DA28EF9D3ED38D FOREIGN KEY (structures_id) REFERENCES structures (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structures_permissions ADD CONSTRAINT FK_15DA28EF9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structures DROP lastname, DROP firstname, CHANGE adress adress VARCHAR(70) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures_permissions DROP FOREIGN KEY FK_15DA28EF9D3ED38D');
        $this->addSql('ALTER TABLE structures_permissions DROP FOREIGN KEY FK_15DA28EF9C3E4F87');
        $this->addSql('DROP TABLE structures_permissions');
        $this->addSql('ALTER TABLE structures ADD lastname VARCHAR(50) NOT NULL, ADD firstname VARCHAR(50) NOT NULL, CHANGE adress adress VARCHAR(100) NOT NULL');
    }
}
