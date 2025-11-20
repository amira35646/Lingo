<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251120113657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON chat_message');
        $this->addSql('ALTER TABLE chat_message DROP id, CHANGE message_id message_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE chat_message ADD PRIMARY KEY (message_id)');
        $this->addSql('ALTER TABLE chat_session MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON chat_session');
        $this->addSql('ALTER TABLE chat_session DROP id');
        $this->addSql('ALTER TABLE chat_session ADD PRIMARY KEY (chat_id)');
        $this->addSql('ALTER TABLE language MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON language');
        $this->addSql('ALTER TABLE language DROP id, CHANGE id_lang id_lang INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE language ADD PRIMARY KEY (id_lang)');
        $this->addSql('ALTER TABLE question MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON question');
        $this->addSql('ALTER TABLE question DROP id, CHANGE id_question id_question INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE question ADD PRIMARY KEY (id_question)');
        $this->addSql('ALTER TABLE quiz MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON quiz');
        $this->addSql('ALTER TABLE quiz DROP id, CHANGE quiz_id quiz_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz ADD PRIMARY KEY (quiz_id)');
        $this->addSql('ALTER TABLE quiz_attempt MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON quiz_attempt');
        $this->addSql('ALTER TABLE quiz_attempt DROP id, CHANGE id_quiz_att id_quiz_att INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE quiz_attempt ADD PRIMARY KEY (id_quiz_att)');
        $this->addSql('ALTER TABLE room MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON room');
        $this->addSql('ALTER TABLE room DROP id, CHANGE room_id room_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE room ADD PRIMARY KEY (room_id)');
        $this->addSql('ALTER TABLE topic MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON topic');
        $this->addSql('ALTER TABLE topic DROP id, CHANGE topic_id topic_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE topic ADD PRIMARY KEY (topic_id)');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON user');
        $this->addSql('ALTER TABLE user DROP id, CHANGE user_id user_id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chat_message ADD id INT AUTO_INCREMENT NOT NULL, CHANGE message_id message_id INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE chat_session ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE language ADD id INT AUTO_INCREMENT NOT NULL, CHANGE id_lang id_lang INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE question ADD id INT AUTO_INCREMENT NOT NULL, CHANGE id_question id_question INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE quiz ADD id INT AUTO_INCREMENT NOT NULL, CHANGE quiz_id quiz_id INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE quiz_attempt ADD id INT AUTO_INCREMENT NOT NULL, CHANGE id_quiz_att id_quiz_att INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE room ADD id INT AUTO_INCREMENT NOT NULL, CHANGE room_id room_id INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE topic ADD id INT AUTO_INCREMENT NOT NULL, CHANGE topic_id topic_id INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE `user` ADD id INT AUTO_INCREMENT NOT NULL, CHANGE user_id user_id INT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
