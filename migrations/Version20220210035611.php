<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220210035611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'List of defaulte categories';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Bar, Café\', \'#34BFFF\', 1, 1, 4, 1);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Gasoline\', \'#0077C5\', 1, 1, 5, 2);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Parking\', \'#00A6A4\', 1, 1, 6, 144);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Utilities\', \'#00C1BF\', 1, 1, 7, 28);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Clothing\', \'#7FD000\', 1, 1, 8, 66);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Education\', \'#FFCA00\', 1, 1, 9, 111);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Gambling\', \'#FFAD00\', 1, 1, 10, 11);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Sport\', \'#EE4036\', 1, 1, 11, 57);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Dining\', \'#9C005E\', 1, 1, 12, 80);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Gift\', \'#652D90\', 1, 1, 13, 78);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Health\', \'#9457FA\', 1, 1, 14, 10);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Home\', \'#E31C9E\', 1, 1, 15, 39);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Beauty\', \'#8B4513\', 1, 1, 16, 100);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Shopping\', \'#5E4138\', 1, 1, 17, 146);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Transport\', \'#FF250B\', 1, 1, 0, 165);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Vacation\', \'#FF2861\', 1, 1, 0, 166);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Other\', \'#FF5877\', 1, 1, 0, 167);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Coupons\', \'#34BFFF\', 0, 1, 2, 158);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Prize\', \'#016165\', 0, 1, 3, 160);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Bounty\', \'#00C1BF\', 0, 1, 4, 152);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Dividend\', \'#FFCA00\', 0, 1, 5, 153);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Investment\', \'#FFAD00\', 0, 1, 6, 162);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Lottery\', \'#EE4036\', 0, 1, 7, 159);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Salary\', \'#9C005E\', 0, 1, 8, 164);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Repayment\', \'#652D90\', 0, 1, 9, 161);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Cashback\', \'#9457FA\', 0, 1, 11, 146);');
        $this->addSql('insert into default_category(name, color, type, active, ordering, icon) values (\'Other\', \'#3485FF\', 0, 1, 0, 165);');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('delete from default_category;');
    }
}
