<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312123524 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD repeated_password VARCHAR(255) NOT NULL, ADD name VARCHAR(255) NOT NULL, ADD postal_code VARCHAR(255) NOT NULL, ADD house_nr VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP repeated_password, DROP name, DROP postal_code, DROP house_nr, DROP address, DROP email, DROP phone');
    }
}
