<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220915111325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures ADD newsletter INT NOT NULL, ADD promote INT NOT NULL, ADD planning INT NOT NULL, ADD statistics INT NOT NULL, ADD products INT NOT NULL, ADD digicode INT NOT NULL, DROP active, DROP description, DROP image, DROP director_name, DROP commercial_contact, DROP technical_contact');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE structures ADD active VARCHAR(15) NOT NULL, ADD description VARCHAR(255) NOT NULL, ADD image VARCHAR(255) NOT NULL, ADD director_name VARCHAR(50) NOT NULL, ADD commercial_contact VARCHAR(50) NOT NULL, ADD technical_contact VARCHAR(50) NOT NULL, DROP newsletter, DROP promote, DROP planning, DROP statistics, DROP products, DROP digicode');
    }
}
