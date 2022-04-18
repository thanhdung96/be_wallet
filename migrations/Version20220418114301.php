<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418114301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add more properties to an account';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, ADD addres VARCHAR(512) DEFAULT NULL, ADD city VARCHAR(512) DEFAULT NULL, ADD country VARCHAR(256) DEFAULT NULL, ADD postal INT DEFAULT NULL, ADD about LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP first_name, DROP last_name, DROP addres, DROP city, DROP country, DROP postal, DROP about');
    }
}
