<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220925160048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album_artist (artist BINARY(16) NOT NULL COMMENT \'(DC2Type:Artist)\', album_id BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', INDEX IDX_D322AB301137ABCF (album_id), PRIMARY KEY(artist, album_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album_track (track BINARY(16) NOT NULL COMMENT \'(DC2Type:TrackId)\', album_id BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', INDEX IDX_A05BB2801137ABCF (album_id), PRIMARY KEY(track, album_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_album (album BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', artist_id BINARY(16) NOT NULL COMMENT \'(DC2Type:Artist)\', INDEX IDX_59945E10B7970CF8 (artist_id), PRIMARY KEY(album, artist_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artist_track (track BINARY(16) NOT NULL COMMENT \'(DC2Type:TrackId)\', artist_id BINARY(16) NOT NULL COMMENT \'(DC2Type:Artist)\', INDEX IDX_B6EFC8F5B7970CF8 (artist_id), PRIMARY KEY(track, artist_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label (id BINARY(16) NOT NULL COMMENT \'(DC2Type:LabelId)\', name VARCHAR(255) NOT NULL COMMENT \'(DC2Type:LabelName)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label_album (album_id BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', label_id BINARY(16) NOT NULL COMMENT \'(DC2Type:LabelId)\', INDEX IDX_AB86D84D33B92F39 (label_id), PRIMARY KEY(album_id, label_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE label_track (track_id BINARY(16) NOT NULL COMMENT \'(DC2Type:TrackId)\', label_id BINARY(16) NOT NULL COMMENT \'(DC2Type:LabelId)\', INDEX IDX_44FD4EA833B92F39 (label_id), PRIMARY KEY(track_id, label_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE track (id BINARY(16) NOT NULL COMMENT \'(DC2Type:TrackId)\', name VARCHAR(255) NOT NULL COMMENT \'(DC2Type:TrackName)\', price DOUBLE PRECISION NOT NULL COMMENT \'(DC2Type:TrackPrice)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_artist ADD CONSTRAINT FK_D322AB301137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE album_track ADD CONSTRAINT FK_A05BB2801137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE artist_album ADD CONSTRAINT FK_59945E10B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE artist_track ADD CONSTRAINT FK_B6EFC8F5B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE label_album ADD CONSTRAINT FK_AB86D84D33B92F39 FOREIGN KEY (label_id) REFERENCES label (id)');
        $this->addSql('ALTER TABLE label_track ADD CONSTRAINT FK_44FD4EA833B92F39 FOREIGN KEY (label_id) REFERENCES label (id)');
        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C11137ABCF');
        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C1B7970CF8');
        $this->addSql('DROP TABLE albums_artists');
        $this->addSql('ALTER TABLE album ADD price DOUBLE PRECISION NOT NULL COMMENT \'(DC2Type:AlbumPrice)\', ADD label_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:LabelId)\', CHANGE title title VARCHAR(255) NOT NULL COMMENT \'(DC2Type:AlbumTitle)\'');
        $this->addSql('ALTER TABLE artist DROP specialisation, DROP adding_date');
        $this->addSql('ALTER TABLE token MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON token');
        $this->addSql('ALTER TABLE token DROP id, CHANGE value value VARCHAR(255) NOT NULL COMMENT \'(DC2Type:TokenValue)\', CHANGE expiration_date expiration_date DATETIME NOT NULL COMMENT \'(DC2Type:TokenExpirationDate)\'');
        $this->addSql('ALTER TABLE token ADD PRIMARY KEY (value, user_id)');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) NOT NULL COMMENT \'(DC2Type:UserEmail)\', CHANGE password password VARCHAR(255) NOT NULL COMMENT \'(DC2Type:UserPassword)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albums_artists (album_id BINARY(16) NOT NULL COMMENT \'(DC2Type:AlbumId)\', artist_id BINARY(16) NOT NULL COMMENT \'(DC2Type:Artist)\', INDEX IDX_8BB2B6C11137ABCF (album_id), INDEX IDX_8BB2B6C1B7970CF8 (artist_id), PRIMARY KEY(album_id, artist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C11137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE album_artist DROP FOREIGN KEY FK_D322AB301137ABCF');
        $this->addSql('ALTER TABLE album_track DROP FOREIGN KEY FK_A05BB2801137ABCF');
        $this->addSql('ALTER TABLE artist_album DROP FOREIGN KEY FK_59945E10B7970CF8');
        $this->addSql('ALTER TABLE artist_track DROP FOREIGN KEY FK_B6EFC8F5B7970CF8');
        $this->addSql('ALTER TABLE label_album DROP FOREIGN KEY FK_AB86D84D33B92F39');
        $this->addSql('ALTER TABLE label_track DROP FOREIGN KEY FK_44FD4EA833B92F39');
        $this->addSql('DROP TABLE album_artist');
        $this->addSql('DROP TABLE album_track');
        $this->addSql('DROP TABLE artist_album');
        $this->addSql('DROP TABLE artist_track');
        $this->addSql('DROP TABLE label');
        $this->addSql('DROP TABLE label_album');
        $this->addSql('DROP TABLE label_track');
        $this->addSql('DROP TABLE track');
        $this->addSql('ALTER TABLE album DROP price, DROP label_id, CHANGE title title VARCHAR(60) NOT NULL COMMENT \'(DC2Type:AlbumTitle)\'');
        $this->addSql('ALTER TABLE user CHANGE email email VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE artist ADD specialisation VARCHAR(80) DEFAULT NULL, ADD adding_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE token ADD id INT AUTO_INCREMENT NOT NULL, CHANGE value value VARCHAR(64) NOT NULL, CHANGE expiration_date expiration_date DATETIME NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
