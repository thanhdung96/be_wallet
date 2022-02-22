<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220322094739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Temporarily remove deb function from transaction.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trans DROP debt_id, DROP debt_trans_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trans ADD debt_id INT NOT NULL, ADD debt_trans_id INT NOT NULL');
    }
}
