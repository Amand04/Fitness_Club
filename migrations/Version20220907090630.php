<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220907090630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partners (id INT AUTO_INCREMENT NOT NULL, store_name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, adress VARCHAR(100) NOT NULL, country VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, phone VARCHAR(25) NOT NULL, image VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partners_permissions (partners_id INT NOT NULL, permissions_id INT NOT NULL, INDEX IDX_CBB993BEBDE7F1C6 (partners_id), INDEX IDX_CBB993BE9C3E4F87 (permissions_id), PRIMARY KEY(partners_id, permissions_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structures (id INT AUTO_INCREMENT NOT NULL, partners_id INT DEFAULT NULL, store_name VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, adress VARCHAR(100) NOT NULL, country VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, phone VARCHAR(25) NOT NULL, image VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, director_name VARCHAR(50) NOT NULL, INDEX IDX_5BBEC55ABDE7F1C6 (partners_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, created_at DATE DEFAULT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partners_permissions ADD CONSTRAINT FK_CBB993BEBDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partners (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE partners_permissions ADD CONSTRAINT FK_CBB993BE9C3E4F87 FOREIGN KEY (permissions_id) REFERENCES permissions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE structures ADD CONSTRAINT FK_5BBEC55ABDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partners (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners_permissions DROP FOREIGN KEY FK_CBB993BEBDE7F1C6');
        $this->addSql('ALTER TABLE partners_permissions DROP FOREIGN KEY FK_CBB993BE9C3E4F87');
        $this->addSql('ALTER TABLE structures DROP FOREIGN KEY FK_5BBEC55ABDE7F1C6');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE partners_permissions');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE structures');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
