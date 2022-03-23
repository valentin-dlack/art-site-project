<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323094301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5F9E962AD5E258C5');
        $this->addSql('DROP INDEX IDX_5F9E962A67B3B43D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comments AS SELECT id, users_id, posts_id FROM comments');
        $this->addSql('DROP TABLE comments');
        $this->addSql('CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, posts_id INTEGER NOT NULL, CONSTRAINT FK_5F9E962A67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_5F9E962AD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comments (id, users_id, posts_id) SELECT id, users_id, posts_id FROM __temp__comments');
        $this->addSql('DROP TABLE __temp__comments');
        $this->addSql('CREATE INDEX IDX_5F9E962AD5E258C5 ON comments (posts_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962A67B3B43D ON comments (users_id)');
        $this->addSql('DROP INDEX IDX_49CA4E7DD5E258C5');
        $this->addSql('DROP INDEX IDX_49CA4E7D67B3B43D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__likes AS SELECT id, users_id, posts_id FROM likes');
        $this->addSql('DROP TABLE likes');
        $this->addSql('CREATE TABLE likes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, posts_id INTEGER NOT NULL, CONSTRAINT FK_49CA4E7D67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_49CA4E7DD5E258C5 FOREIGN KEY (posts_id) REFERENCES posts (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO likes (id, users_id, posts_id) SELECT id, users_id, posts_id FROM __temp__likes');
        $this->addSql('DROP TABLE __temp__likes');
        $this->addSql('CREATE INDEX IDX_49CA4E7DD5E258C5 ON likes (posts_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7D67B3B43D ON likes (users_id)');
        $this->addSql('DROP INDEX IDX_885DBAFA67B3B43D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__posts AS SELECT id, users_id, title, content, files FROM posts');
        $this->addSql('DROP TABLE posts');
        $this->addSql('CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, content CLOB NOT NULL, files CLOB DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_885DBAFA67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO posts (id, users_id, title, content, files) SELECT id, users_id, title, content, files FROM __temp__posts');
        $this->addSql('DROP TABLE __temp__posts');
        $this->addSql('CREATE INDEX IDX_885DBAFA67B3B43D ON posts (users_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_5F9E962A67B3B43D');
        $this->addSql('DROP INDEX IDX_5F9E962AD5E258C5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comments AS SELECT id, users_id, posts_id FROM comments');
        $this->addSql('DROP TABLE comments');
        $this->addSql('CREATE TABLE comments (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, posts_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO comments (id, users_id, posts_id) SELECT id, users_id, posts_id FROM __temp__comments');
        $this->addSql('DROP TABLE __temp__comments');
        $this->addSql('CREATE INDEX IDX_5F9E962A67B3B43D ON comments (users_id)');
        $this->addSql('CREATE INDEX IDX_5F9E962AD5E258C5 ON comments (posts_id)');
        $this->addSql('DROP INDEX IDX_49CA4E7D67B3B43D');
        $this->addSql('DROP INDEX IDX_49CA4E7DD5E258C5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__likes AS SELECT id, users_id, posts_id FROM likes');
        $this->addSql('DROP TABLE likes');
        $this->addSql('CREATE TABLE likes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, posts_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO likes (id, users_id, posts_id) SELECT id, users_id, posts_id FROM __temp__likes');
        $this->addSql('DROP TABLE __temp__likes');
        $this->addSql('CREATE INDEX IDX_49CA4E7D67B3B43D ON likes (users_id)');
        $this->addSql('CREATE INDEX IDX_49CA4E7DD5E258C5 ON likes (posts_id)');
        $this->addSql('DROP INDEX IDX_885DBAFA67B3B43D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__posts AS SELECT id, users_id, title, content, files FROM posts');
        $this->addSql('DROP TABLE posts');
        $this->addSql('CREATE TABLE posts (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, users_id INTEGER NOT NULL, title VARCHAR(100) NOT NULL, content CLOB NOT NULL, files CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO posts (id, users_id, title, content, files) SELECT id, users_id, title, content, files FROM __temp__posts');
        $this->addSql('DROP TABLE __temp__posts');
        $this->addSql('CREATE INDEX IDX_885DBAFA67B3B43D ON posts (users_id)');
    }
}
