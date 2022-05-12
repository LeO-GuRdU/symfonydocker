<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220511135759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recetas (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, tipo VARCHAR(25) NOT NULL, cant INT NOT NULL, dificultad VARCHAR(50) NOT NULL, ingredientes JSON NOT NULL, pasos LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', imagen VARCHAR(255) DEFAULT NULL, INDEX IDX_8ADA30D59D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, user_name VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, date DATETIME NOT NULL, image VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recetas ADD CONSTRAINT FK_8ADA30D59D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recetas DROP FOREIGN KEY FK_8ADA30D59D86650F');
        $this->addSql('DROP TABLE recetas');
        $this->addSql('DROP TABLE user');
    }
}
