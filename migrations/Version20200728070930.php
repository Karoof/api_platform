<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200728070930 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workout_plan (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE workout_plan_exercise (workout_plan_id INT NOT NULL, exercise_id INT NOT NULL, INDEX IDX_7FFCB47945F6E33 (workout_plan_id), INDEX IDX_7FFCB47E934951A (exercise_id), PRIMARY KEY(workout_plan_id, exercise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE workout_plan_exercise ADD CONSTRAINT FK_7FFCB47945F6E33 FOREIGN KEY (workout_plan_id) REFERENCES workout_plan (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE workout_plan_exercise ADD CONSTRAINT FK_7FFCB47E934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workout_plan_exercise DROP FOREIGN KEY FK_7FFCB47945F6E33');
        $this->addSql('DROP TABLE workout_plan');
        $this->addSql('DROP TABLE workout_plan_exercise');
    }
}
