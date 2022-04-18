<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419110803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move default currency to account setting.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A438248176');
        $this->addSql('DROP INDEX IDX_7D3656A438248176 ON account');
        $this->addSql('ALTER TABLE account DROP currency_id');
        $this->addSql('ALTER TABLE account_setting ADD currency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account_setting ADD CONSTRAINT FK_565FACD038248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('CREATE INDEX IDX_565FACD038248176 ON account_setting (currency_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account ADD currency_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A438248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
        $this->addSql('CREATE INDEX IDX_7D3656A438248176 ON account (currency_id)');
        $this->addSql('ALTER TABLE account_setting DROP FOREIGN KEY FK_565FACD038248176');
        $this->addSql('DROP INDEX IDX_565FACD038248176 ON account_setting');
        $this->addSql('ALTER TABLE account_setting DROP currency_id');
    }
}
