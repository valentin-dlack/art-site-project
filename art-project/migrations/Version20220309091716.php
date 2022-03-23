<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309091716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, posts_id INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_5F9E962A67B3B43D ON comments (users_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AD5E258C5 ON comments (posts_id)');
        $this->addSql('CREATE TABLE likes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, posts_id INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D67B3B43D ON likes (users_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7DD5E258C5 ON likes (posts_id)');
        $this->addSql('CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, content CLOB NOT NULL, files CLOB DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_885DBAFA67B3B43D ON posts (users_id)');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, coms_state INTEGER NOT NULL, user_state INTEGER NOT NULL, profile_picture VARCHAR(255) DEFAULT \'None\')');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9E7927C74 ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE likes');
        $this->addSql('DROP TABLE posts');
        $this->addSql('DROP TABLE users');
    }
}
