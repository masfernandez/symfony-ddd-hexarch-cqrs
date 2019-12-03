<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180323125254 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C11137ABCF');
        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C1B7970CF8');
        $this->addSql('ALTER TABLE albums_artists DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C11137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id)');
        $this->addSql('ALTER TABLE albums_artists ADD PRIMARY KEY (album_id, artist_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C11137ABCF');
        $this->addSql('ALTER TABLE albums_artists DROP FOREIGN KEY FK_8BB2B6C1B7970CF8');
        $this->addSql('ALTER TABLE albums_artists DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C11137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE albums_artists ADD CONSTRAINT FK_8BB2B6C1B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE albums_artists ADD PRIMARY KEY (artist_id, album_id)');
    }
}
