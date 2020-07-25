<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200724135038 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exercise (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rep (id INT AUTO_INCREMENT NOT NULL, progression_id INT DEFAULT NULL, number INT NOT NULL, weight INT NOT NULL, INDEX IDX_E0BB8BF2AF229C18 (progression_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `set` (id INT AUTO_INCREMENT NOT NULL, exercise_id INT DEFAULT NULL, number INT NOT NULL, INDEX IDX_E61425DCE934951A (exercise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rep ADD CONSTRAINT FK_E0BB8BF2AF229C18 FOREIGN KEY (progression_id) REFERENCES `set` (id)');
        $this->addSql('ALTER TABLE `set` ADD CONSTRAINT FK_E61425DCE934951A FOREIGN KEY (exercise_id) REFERENCES exercise (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `set` DROP FOREIGN KEY FK_E61425DCE934951A');
        $this->addSql('ALTER TABLE rep DROP FOREIGN KEY FK_E0BB8BF2AF229C18');
        $this->addSql('DROP TABLE exercise');
        $this->addSql('DROP TABLE rep');
        $this->addSql('DROP TABLE `set`');
    }
}
