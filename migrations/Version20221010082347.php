<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221010082347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE partners (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, email VARCHAR(180) NOT NULL, name VARCHAR(30) NOT NULL, short_description VARCHAR(150) NOT NULL, long_description VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, technical_contact VARCHAR(255) NOT NULL, commercial_contact VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_EFEB5164A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE permissions (id INT AUTO_INCREMENT NOT NULL, partners_id INT NOT NULL, perms VARCHAR(30) NOT NULL, active TINYINT(1) NOT NULL, INDEX IDX_2DEDCC6FBDE7F1C6 (partners_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE structures (id INT AUTO_INCREMENT NOT NULL, partners_id INT NOT NULL, user_id INT NOT NULL, store_name VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, adress VARCHAR(70) NOT NULL, country VARCHAR(50) NOT NULL, phone VARCHAR(25) NOT NULL, active TINYINT(1) NOT NULL, newsletter TINYINT(1) NOT NULL, promote TINYINT(1) NOT NULL, planning TINYINT(1) NOT NULL, products TINYINT(1) NOT NULL, digicode TINYINT(1) NOT NULL, statistics TINYINT(1) NOT NULL, INDEX IDX_5BBEC55ABDE7F1C6 (partners_id), INDEX IDX_5BBEC55AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE partners ADD CONSTRAINT FK_EFEB5164A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE permissions ADD CONSTRAINT FK_2DEDCC6FBDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partners (id)');
        $this->addSql('ALTER TABLE structures ADD CONSTRAINT FK_5BBEC55ABDE7F1C6 FOREIGN KEY (partners_id) REFERENCES partners (id)');
        $this->addSql('ALTER TABLE structures ADD CONSTRAINT FK_5BBEC55AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partners DROP FOREIGN KEY FK_EFEB5164A76ED395');
        $this->addSql('ALTER TABLE permissions DROP FOREIGN KEY FK_2DEDCC6FBDE7F1C6');
        $this->addSql('ALTER TABLE structures DROP FOREIGN KEY FK_5BBEC55ABDE7F1C6');
        $this->addSql('ALTER TABLE structures DROP FOREIGN KEY FK_5BBEC55AA76ED395');
        $this->addSql('DROP TABLE partners');
        $this->addSql('DROP TABLE permissions');
        $this->addSql('DROP TABLE structures');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
