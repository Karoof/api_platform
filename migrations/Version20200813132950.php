<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200813132950 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout_plan_user (workout_plan_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_BA9F7DEF945F6E33 (workout_plan_id), INDEX IDX_BA9F7DEFA76ED395 (user_id), PRIMARY KEY(workout_plan_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workout_plan_user ADD CONSTRAINT FK_BA9F7DEF945F6E33 FOREIGN KEY (workout_plan_id) REFERENCES workout_plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_plan_user ADD CONSTRAINT FK_BA9F7DEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE workout_plan_user');
    }
}
