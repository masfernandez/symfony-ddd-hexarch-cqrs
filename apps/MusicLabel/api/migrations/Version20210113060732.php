<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113060732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE album (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', 
                title VARCHAR(60) NOT NULL COMMENT \'(DC2Type:AlbumTitle)\', 
                release_date DATETIME NOT NULL COMMENT \'(DC2Type:AlbumReleasedAtDate)\', 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE albums_artists (
                album_id BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', 
                artist_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ArtistId)\', 
                INDEX IDX_8BB2B6C11137ABCF (album_id), 
                INDEX IDX_8BB2B6C1B7970CF8 (artist_id), 
                PRIMARY KEY(album_id, artist_id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE artist (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:ArtistId)\', 
                name VARCHAR(255) NOT NULL, 
                specialisation VARCHAR(80) NULL, 
                adding_date DATETIME NOT NULL, 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE token (
                id INT AUTO_INCREMENT NOT NULL, 
                user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:UserId)\', 
                value VARCHAR(64) NOT NULL, 
                expiration_date DATETIME NOT NULL, 
                INDEX IDX_5F37A13BA76ED395 (user_id), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE user (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:UserId)\', 
                email VARCHAR(255) NOT NULL, 
                password VARCHAR(255) NOT NULL, 
                UNIQUE INDEX email_idx (email), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            CREATE TABLE messenger_messages (
                id BIGINT AUTO_INCREMENT NOT NULL, 
                body LONGTEXT NOT NULL, 
                headers LONGTEXT NOT NULL, 
                queue_name VARCHAR(190) NOT NULL, 
                created_at DATETIME NOT NULL, 
                available_at DATETIME NOT NULL, 
                delivered_at DATETIME DEFAULT NULL, 
                INDEX IDX_75EA56E0FB7336F0 (queue_name), 
                INDEX IDX_75EA56E0E3BD61CE (available_at), 
                INDEX IDX_75EA56E016BA31DB (delivered_at), 
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
        $this->addSql('
            ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)
        ');
        $this->addSql('
            ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)
        ');
        $this->addSql('
            ALTER TABLE token ADD CONSTRAINT FK_5F37A13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('
            ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C11137ABCF
        ');
        $this->addSql('
            ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C1B7970CF8
        ');
        $this->addSql('
            ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BA76ED395
        ');
        $this->addSql('
            DROP TABLE album
        ');
        $this->addSql('
            DROP TABLE albums_artists
        ');
        $this->addSql('
            DROP TABLE artist
        ');
        $this->addSql('
            DROP TABLE token
        ');
        $this->addSql('
            DROP TABLE user
        ');
        $this->addSql('
            DROP TABLE messenger_messages
        ');
    }
}
