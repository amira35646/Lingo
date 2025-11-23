<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251123103115 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat_rooms (room_id INT AUTO_INCREMENT NOT NULL, topic_id INT DEFAULT NULL, target_language_id INT DEFAULT NULL, proficiency_level_id INT DEFAULT NULL, max_participants INT NOT NULL, scheduled_time DATETIME NOT NULL, duration_minutes INT NOT NULL, created_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', room_status VARCHAR(255) NOT NULL, INDEX IDX_7DDCF70D1F55203D (topic_id), INDEX IDX_7DDCF70D5CBF5FE (target_language_id), INDEX IDX_7DDCF70D1A57A5BF (proficiency_level_id), PRIMARY KEY(room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_participants (room_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C71B680154177093 (room_id), INDEX IDX_C71B6801A76ED395 (user_id), PRIMARY KEY(room_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room_ready_users (room_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A7027D5D54177093 (room_id), INDEX IDX_A7027D5DA76ED395 (user_id), PRIMARY KEY(room_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_sessions (id INT AUTO_INCREMENT NOT NULL, room_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AE424A2354177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat_session_participants (chat_session_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B5CC441CA6CEA979 (chat_session_id), INDEX IDX_B5CC441CA76ED395 (user_id), PRIMARY KEY(chat_session_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, UNIQUE INDEX UNIQ_D4DB71B55E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, sender_id BIGINT NOT NULL, sender_type VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, timestamp DATETIME NOT NULL, corrections_json LONGTEXT DEFAULT NULL, sender_name VARCHAR(255) DEFAULT NULL, correction LONGTEXT DEFAULT NULL, translation LONGTEXT DEFAULT NULL, tip LONGTEXT DEFAULT NULL, is_correct TINYINT(1) DEFAULT 0 NOT NULL, mistake_type VARCHAR(100) DEFAULT NULL, INDEX IDX_B6BD307F613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proficiency_level (id INT AUTO_INCREMENT NOT NULL, language_id INT NOT NULL, level_name VARCHAR(50) NOT NULL, INDEX IDX_4FEC0B2882F1BAF4 (language_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE question (id_question INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, reponsecorrecte VARCHAR(255) NOT NULL, PRIMARY KEY(id_question)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz (quiz_id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, datecreation DATE NOT NULL, PRIMARY KEY(quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_attempt (id_quiz_att INT AUTO_INCREMENT NOT NULL, quiz_id INT NOT NULL, date_start DATE NOT NULL, dateend DATE NOT NULL, score INT NOT NULL, INDEX IDX_AB6AFC6853CD175 (quiz_id), PRIMARY KEY(id_quiz_att)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, topic_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', last_login DATETIME DEFAULT NULL, native_language VARCHAR(100) DEFAULT NULL, target_language VARCHAR(100) DEFAULT NULL, proficiency_level VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat_rooms ADD CONSTRAINT FK_7DDCF70D1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE chat_rooms ADD CONSTRAINT FK_7DDCF70D5CBF5FE FOREIGN KEY (target_language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE chat_rooms ADD CONSTRAINT FK_7DDCF70D1A57A5BF FOREIGN KEY (proficiency_level_id) REFERENCES proficiency_level (id)');
        $this->addSql('ALTER TABLE room_participants ADD CONSTRAINT FK_C71B680154177093 FOREIGN KEY (room_id) REFERENCES chat_rooms (room_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_participants ADD CONSTRAINT FK_C71B6801A76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_ready_users ADD CONSTRAINT FK_A7027D5D54177093 FOREIGN KEY (room_id) REFERENCES chat_rooms (room_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE room_ready_users ADD CONSTRAINT FK_A7027D5DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat_sessions ADD CONSTRAINT FK_AE424A2354177093 FOREIGN KEY (room_id) REFERENCES chat_rooms (room_id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE chat_session_participants ADD CONSTRAINT FK_B5CC441CA6CEA979 FOREIGN KEY (chat_session_id) REFERENCES chat_sessions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE chat_session_participants ADD CONSTRAINT FK_B5CC441CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F613FECDF FOREIGN KEY (session_id) REFERENCES chat_sessions (id)');
        $this->addSql('ALTER TABLE proficiency_level ADD CONSTRAINT FK_4FEC0B2882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id)');
        $this->addSql('ALTER TABLE quiz_attempt ADD CONSTRAINT FK_AB6AFC6853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_rooms DROP FOREIGN KEY FK_7DDCF70D1F55203D');
        $this->addSql('ALTER TABLE chat_rooms DROP FOREIGN KEY FK_7DDCF70D5CBF5FE');
        $this->addSql('ALTER TABLE chat_rooms DROP FOREIGN KEY FK_7DDCF70D1A57A5BF');
        $this->addSql('ALTER TABLE room_participants DROP FOREIGN KEY FK_C71B680154177093');
        $this->addSql('ALTER TABLE room_participants DROP FOREIGN KEY FK_C71B6801A76ED395');
        $this->addSql('ALTER TABLE room_ready_users DROP FOREIGN KEY FK_A7027D5D54177093');
        $this->addSql('ALTER TABLE room_ready_users DROP FOREIGN KEY FK_A7027D5DA76ED395');
        $this->addSql('ALTER TABLE chat_sessions DROP FOREIGN KEY FK_AE424A2354177093');
        $this->addSql('ALTER TABLE chat_session_participants DROP FOREIGN KEY FK_B5CC441CA6CEA979');
        $this->addSql('ALTER TABLE chat_session_participants DROP FOREIGN KEY FK_B5CC441CA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F613FECDF');
        $this->addSql('ALTER TABLE proficiency_level DROP FOREIGN KEY FK_4FEC0B2882F1BAF4');
        $this->addSql('ALTER TABLE quiz_attempt DROP FOREIGN KEY FK_AB6AFC6853CD175');
        $this->addSql('DROP TABLE chat_rooms');
        $this->addSql('DROP TABLE room_participants');
        $this->addSql('DROP TABLE room_ready_users');
        $this->addSql('DROP TABLE chat_sessions');
        $this->addSql('DROP TABLE chat_session_participants');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE proficiency_level');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_attempt');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
