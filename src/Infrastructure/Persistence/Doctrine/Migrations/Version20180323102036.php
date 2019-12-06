<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180323102036 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE artist (id CHAR(36) NOT NULL COMMENT \'(DC2Type:ArtistId)\', name VARCHAR(500) NOT NULL, specialisation VARCHAR(500) NOT NULL, adding_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE albums_artists (artist_id CHAR(36) NOT NULL COMMENT \'(DC2Type:ArtistId)\', album_id CHAR(36) NOT NULL COMMENT \'(DC2Type:AlbumId)\', INDEX IDX_8BB2B6C1B7970CF8 (artist_id), INDEX IDX_8BB2B6C11137ABCF (album_id), PRIMARY KEY(artist_id, album_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (id CHAR(36) NOT NULL COMMENT \'(DC2Type:AlbumId)\', title VARCHAR(500) NOT NULL, publishing_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C11137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C1B7970CF8');
        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C11137ABCF');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE albums_artists');
        $this->addSql('DROP TABLE album');
    }
}
