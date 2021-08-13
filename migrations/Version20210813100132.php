<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813100132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'List of default currencies and symbols';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('insert into currency(currency_name, symbol) values(\'Albanian Lek\', \'L\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Argentine Peso\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Armenian Dram\', \'Դ\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Australian Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Azerbaijan Manat\', \'ман\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Belarus Ruble\', \'Br\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Boliviano\', \'Bs.\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Pula\', \'P\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Bulgaria Lev\', \'Лв.\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Brazilian Real\', \'R$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Cambodia Riel\', \'៛\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Canadian Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'China Yuan\', \'¥\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Colombian Peso\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Costa Rican Colon\', \'₡\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Croatia Kuna\', \'kn\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Cuban Peso\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Czech Koruna\', \'Kč\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Danish Krone\', \'kr\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Dominican Peso\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Egyptian Pound\', \'£\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'El Salvador Colon\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Euro\', \'€\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Fiji Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Ghana Cedi\', \'¢\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Guatemala\', \'Q\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Guinea Franc\', \'₣\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Guyana Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Hong Kong Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Honduras Lempira\', \'L\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Hungary Forint\', \'Ft\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Indonesia Rupiah\', \'Rp\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'India Rupiah\', \'₹\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Icelandic Krona\', \'kr\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Iran Rial\', \'﷼\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Israel Shekel\', \'₪\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Japan Yen\', \'¥\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Kazakhstan Tenge\', \'лв\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Kenyan Shilling\', \'ksh\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Kuwaiti Dinar\', \'د.ك\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Malawi Kwacha\', \'MK\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Malaysia Ringgit\', \'RM\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Mexico Peso\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Moroccan Dirham\', \'DH\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Namibian Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Nepalese Rupee\', \'Rs\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'New Zealand Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Norwegian Krone\', \'kr\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Rial Omani\', \'ر.ع.\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Pakistan Rupee\', \'Rs\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Nuevo Sol\', \'S/.\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Philippine Peso\', \'₱\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Polish Zloty\', \'zł\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Qatari Riyal\', \'QR\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Romanian Leu\', \'L\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Russian Ruble\', \'p.\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Saudi Riyal\', \'ر.س\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Serbia Dinar\', \'Дин.\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Seychelles Rupee\', \'₨\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Singapore Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Solomon Islands Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Somalia Shilling\', \'S\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'South African Rand\', \'R\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Sri Lanka Rupee\', \'Rs\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Sweden Krona\', \'kr\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Switzerland Franc\', \'CHF\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Syrian Pound\', \'£\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Taiwan New Dollar\', \'NT$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Thailand Baht\', \'฿\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Trinidad and Tobago Dollar\', \'TT$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Turkish Lira\', \'₺\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Ukrainian Hryvnia\', \'₴\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Pounds Sterling\', \'£\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'US Dollar\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Uruguayan Peso\', \'$\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Uzbekistan\', \'UZS\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Bolivar Fuerte\', \'Bs F\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Vietnamese Dong\', \'₫\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Yemeni Rial\', \'﷼\');');
        $this->addSql('insert into currency(currency_name, symbol) values(\'Zimbabwe Dollar\', \'$\');');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('delete from currency;');
    }
}
