<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200725212851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE rep ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `set` ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exercise DROP created_at');
        $this->addSql('ALTER TABLE rep DROP created_at');
        $this->addSql('ALTER TABLE `set` DROP created_at');
    }
}
