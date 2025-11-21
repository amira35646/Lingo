<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251121072542 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE room_user (user_id INT NOT NULL, room_id INT NOT NULL, INDEX IDX_EE973C2DA76ED395 (user_id), INDEX IDX_EE973C2D54177093 (room_id), PRIMARY KEY(user_id, room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE room_user ADD CONSTRAINT FK_EE973C2DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (user_id)');
        $this->addSql('ALTER TABLE room_user ADD CONSTRAINT FK_EE973C2D54177093 FOREIGN KEY (room_id) REFERENCES room (room_id)');
        $this->addSql('ALTER TABLE language ADD lan_id INT NOT NULL, ADD lang_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quiz_attempt ADD quiz_id INT NOT NULL');
        $this->addSql('ALTER TABLE quiz_attempt ADD CONSTRAINT FK_AB6AFC6853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (quiz_id)');
        $this->addSql('CREATE INDEX IDX_AB6AFC6853CD175 ON quiz_attempt (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room_user DROP FOREIGN KEY FK_EE973C2DA76ED395');
        $this->addSql('ALTER TABLE room_user DROP FOREIGN KEY FK_EE973C2D54177093');
        $this->addSql('DROP TABLE room_user');
        $this->addSql('ALTER TABLE language DROP lan_id, DROP lang_name');
        $this->addSql('ALTER TABLE quiz_attempt DROP FOREIGN KEY FK_AB6AFC6853CD175');
        $this->addSql('DROP INDEX IDX_AB6AFC6853CD175 ON quiz_attempt');
        $this->addSql('ALTER TABLE quiz_attempt DROP quiz_id');
    }
}
