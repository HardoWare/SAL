<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230820191951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log ADD log_time_stamp DATETIME NOT NULL, ADD log_message LONGTEXT NOT NULL, DROP log_data');
        //$this->addSql('ALTER TABLE remote_host CHANGE interval_start interval_start DATETIME NOT NULL, CHANGE interval_end interval_end DATETIME NOT NULL');
        //$this->addSql('CREATE UNIQUE INDEX UNIQ_4ADEBF245E237E06 ON remote_host (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log ADD log_data LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP log_time_stamp, DROP log_message');
        $this->addSql('DROP INDEX UNIQ_4ADEBF245E237E06 ON remote_host');
        $this->addSql('ALTER TABLE remote_host CHANGE interval_start interval_start DATETIME DEFAULT NULL, CHANGE interval_end interval_end DATETIME DEFAULT NULL');
    }
}
