<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329184824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE injure (id INT AUTO_INCREMENT NOT NULL, libelle LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reaction (id INT AUTO_INCREMENT NOT NULL, wish_id INT NOT NULL, username VARCHAR(50) NOT NULL, message LONGTEXT NOT NULL, date_created DATETIME NOT NULL, INDEX IDX_A4D707F742B83698 (wish_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wish (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, title VARCHAR(250) NOT NULL, description LONGTEXT DEFAULT NULL, is_published TINYINT(1) DEFAULT NULL, author VARCHAR(50) NOT NULL, date_created DATETIME DEFAULT NULL, likes INT NOT NULL, INDEX IDX_D7D174C9BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reaction ADD CONSTRAINT FK_A4D707F742B83698 FOREIGN KEY (wish_id) REFERENCES wish (id)');
        $this->addSql('ALTER TABLE wish ADD CONSTRAINT FK_D7D174C9BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wish DROP FOREIGN KEY FK_D7D174C9BCF5E72D');
        $this->addSql('ALTER TABLE reaction DROP FOREIGN KEY FK_A4D707F742B83698');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE injure');
        $this->addSql('DROP TABLE reaction');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE wish');
    }
}
