<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210903095725 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update account entity for authentication';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD roles JSON NOT NULL, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE account RENAME INDEX email_unique TO UNIQ_7D3656A4E7927C74');
        $this->addSql('ALTER TABLE account RENAME INDEX currency_fk_idx TO IDX_7D3656A438248176');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP roles, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE account RENAME INDEX uniq_7d3656a4e7927c74 TO email_UNIQUE');
        $this->addSql('ALTER TABLE account RENAME INDEX idx_7d3656a438248176 TO currency_fk_idx');
    }
}
