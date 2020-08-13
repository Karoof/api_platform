<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813140551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout_plan ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE workout_plan ADD CONSTRAINT FK_A5D458017E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_A5D458017E3C61F9 ON workout_plan (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout_plan DROP FOREIGN KEY FK_A5D458017E3C61F9');
        $this->addSql('DROP INDEX IDX_A5D458017E3C61F9 ON workout_plan');
        $this->addSql('ALTER TABLE workout_plan DROP owner_id');
    }
}
