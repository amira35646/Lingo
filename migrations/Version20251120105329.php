<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20251120105329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE chat_message (
            message_id INT AUTO_INCREMENT NOT NULL,
            sender_id INT NOT NULL,
            content VARCHAR(255) NOT NULL,
            corrections VARCHAR(255) NOT NULL,
            sender_name VARCHAR(255) NOT NULL,
            sendertype VARCHAR(255) NOT NULL,
            sendername VARCHAR(255) NOT NULL,
            timestamp DATE NOT NULL,
            PRIMARY KEY(message_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE chat_session (
            chat_id VARCHAR(255) NOT NULL,
            start_time DATE NOT NULL,
            end_time DATE NOT NULL,
            PRIMARY KEY(chat_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE language (
            id_lang INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            id_topic INT NOT NULL,
            topic_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id_lang)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE question (
            id_question INT AUTO_INCREMENT NOT NULL,
            text VARCHAR(255) NOT NULL,
            reponsecorrecte VARCHAR(255) NOT NULL,
            PRIMARY KEY(id_question)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE quiz (
            quiz_id INT AUTO_INCREMENT NOT NULL,
            score INT NOT NULL,
            datecreation DATE NOT NULL,
            PRIMARY KEY(quiz_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE quiz_attempt (
            id_quiz_att INT AUTO_INCREMENT NOT NULL,
            date_start DATE NOT NULL,
            dateend DATE NOT NULL,
            score INT NOT NULL,
            PRIMARY KEY(id_quiz_att)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE room (
            room_id INT AUTO_INCREMENT NOT NULL,
            max_participants INT NOT NULL,
            scheduled_time DATE NOT NULL,
            duration_minutes INT NOT NULL,
            created_by VARCHAR(255) NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            room_status VARCHAR(255) NOT NULL,
            PRIMARY KEY(room_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE topic (
            topic_id INT AUTO_INCREMENT NOT NULL,
            topic_name VARCHAR(255) NOT NULL,
            PRIMARY KEY(topic_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE `user` (
            user_id INT AUTO_INCREMENT NOT NULL,
            email VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            PRIMARY KEY(user_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE messenger_messages (
            id BIGINT AUTO_INCREMENT NOT NULL,
            body LONGTEXT NOT NULL,
            headers LONGTEXT NOT NULL,
            queue_name VARCHAR(190) NOT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            INDEX IDX_75EA56E0FB7336F0 (queue_name),
            INDEX IDX_75EA56E0E3BD61CE (available_at),
            INDEX IDX_75EA56E016BA31DB (delivered_at),
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE chat_message');
        $this->addSql('DROP TABLE chat_session');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE question');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_attempt');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
