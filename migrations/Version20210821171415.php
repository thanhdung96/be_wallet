<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210821171415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Resize color field of wallet to 255 instead of text type';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet
            CHANGE color color VARCHAR(255) DEFAULT NULL,
            CHANGE active active TINYINT(1) DEFAULT \'1\' NOT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet
            CHANGE color color TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, 
            CHANGE active active TINYINT(1) DEFAULT \'0\' NOT NULL');
    }
}
