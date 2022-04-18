<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418085650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added application setting for account.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE account_setting (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT NULL, dark_mode TINYINT(1) NOT NULL, name VARCHAR(10) NOT NULL, created DATETIME NOT NULL, modified DATETIME NOT NULL, UNIQUE INDEX UNIQ_565FACD09B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account_setting ADD CONSTRAINT FK_565FACD09B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE account ADD setting_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4EE35BD72 FOREIGN KEY (setting_id) REFERENCES account_setting (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A4EE35BD72 ON account (setting_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4EE35BD72');
        $this->addSql('DROP TABLE account_setting');
        $this->addSql('DROP INDEX UNIQ_7D3656A4EE35BD72 ON account');
        $this->addSql('ALTER TABLE account DROP setting_id');
    }
}
