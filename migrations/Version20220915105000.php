<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915105000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners ADD active VARCHAR(30) NOT NULL, ADD short_description VARCHAR(150) NOT NULL, ADD long_description VARCHAR(255) NOT NULL, ADD logo VARCHAR(255) DEFAULT NULL, ADD url VARCHAR(255) DEFAULT NULL, ADD technical_commercial VARCHAR(255) NOT NULL, ADD tecnichal_commercial VARCHAR(255) NOT NULL, ADD technical_contact VARCHAR(255) NOT NULL, ADD commercial_contact VARCHAR(255) NOT NULL, DROP newsletter, DROP promote, DROP planning, DROP statistics, DROP products, DROP digicode');
        $this->addSql('ALTER TABLE permissions CHANGE perms perms VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners ADD newsletter INT NOT NULL, ADD promote INT NOT NULL, ADD planning INT NOT NULL, ADD statistics INT NOT NULL, ADD products INT NOT NULL, ADD digicode INT NOT NULL, DROP active, DROP short_description, DROP long_description, DROP logo, DROP url, DROP technical_commercial, DROP tecnichal_commercial, DROP technical_contact, DROP commercial_contact');
        $this->addSql('ALTER TABLE permissions CHANGE perms perms VARCHAR(255) NOT NULL');
    }
}
