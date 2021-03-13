<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312144018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activiteiten DROP FOREIGN KEY FK_1C50895F3DEE50DF');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, time TIME DEFAULT NULL, price NUMERIC(6, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moment (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, date DATE DEFAULT NULL, time TIME DEFAULT NULL, INDEX IDX_358C88A212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE moment ADD CONSTRAINT FK_358C88A212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('DROP TABLE activiteiten');
        $this->addSql('DROP TABLE soort_activiteiten');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE moment DROP FOREIGN KEY FK_358C88A212469DE2');
        $this->addSql('CREATE TABLE activiteiten (id INT AUTO_INCREMENT NOT NULL, soort_id INT DEFAULT NULL, datum DATE DEFAULT NULL, tijd TIME DEFAULT NULL, INDEX IDX_1C50895F3DEE50DF (soort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE soort_activiteiten (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, min_leeftijd INT NOT NULL, tijdsduur INT DEFAULT NULL, prijs NUMERIC(6, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE activiteiten ADD CONSTRAINT FK_1C50895F3DEE50DF FOREIGN KEY (soort_id) REFERENCES soort_activiteiten (id)');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE moment');
    }
}
