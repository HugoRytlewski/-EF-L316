<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250218172301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, subject_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_5F9E962A23EDC87 (subject_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments_user (comments_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_942FBEE63379586 (comments_id), INDEX IDX_942FBEEA76ED395 (user_id), PRIMARY KEY(comments_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, id_subject_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, is_liked TINYINT(1) NOT NULL, INDEX IDX_AC6340B3A7B45C50 (id_subject_id), INDEX IDX_AC6340B379F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content VARCHAR(500) NOT NULL, is_reported TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE comments_user ADD CONSTRAINT FK_942FBEE63379586 FOREIGN KEY (comments_id) REFERENCES comments (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments_user ADD CONSTRAINT FK_942FBEEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A7B45C50 FOREIGN KEY (id_subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B379F37AE5 FOREIGN KEY (id_user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A23EDC87');
        $this->addSql('ALTER TABLE comments_user DROP FOREIGN KEY FK_942FBEE63379586');
        $this->addSql('ALTER TABLE comments_user DROP FOREIGN KEY FK_942FBEEA76ED395');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A7B45C50');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B379F37AE5');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE comments_user');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE subject');
    }
}
