<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Album;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Catalog\Domain\Artist\Artist;
use Masfernandez\MusicLabel\Shared\Domain\Aggregate;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
use Masfernandez\MusicLabel\Shared\Domain\DomainEvent;
use Stringable;

// Cannot be final cause: Unable to create a proxy for a final exception
// It doesn't mean is open to inheritance...
class Album extends Aggregate implements Stringable
{
    public const ID           = 'id';
    public const TITLE        = 'title';
    public const RELEASE_DATE = 'releaseDate';
    public const DATE_FORMAT  = 'Y-m-d H:i:s';
    private Collection $artists;

    private function __construct(
        private AlbumId $id,
        private AlbumTitle $title,
        private AlbumReleaseDate $releaseDate
    ) {
        $this->artists = new ArrayCollection();
        $this->collectEvent(
            new AlbumCreatedDomainEvent(
                $id->value(),
                $title->value(),
                $releaseDate->value(),
                null,
                (new DateTime())->format(DomainEvent::$dateFormat)
            )
        );
    }

    public static function create(AlbumId $id, AlbumTitle $title, AlbumReleaseDate $releaseDate): Album
    {
        return new self($id, $title, $releaseDate);
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getTitle(): AlbumTitle
    {
        return $this->title;
    }

    public function getReleaseDate(): AlbumReleaseDate
    {
        return $this->releaseDate;
    }

    /**
     * @return string[]
     */
    public static function getFieldNames(): array
    {
        return [
            self::ID,
            self::TITLE,
            self::RELEASE_DATE
        ];
    }

    public function update(?AlbumTitle $title, ?AlbumReleaseDate $releaseDate): void
    {
        $this->title       = $title ?: $this->title;
        $this->releaseDate = $releaseDate ?: $this->releaseDate;
    }

    public function addArtist(Artist $artist): void
    {
        $artist->addAlbum($this); // synchronously updating inverse side
        $this->artists->add($artist);
    }

    public function deleteArtist(Artist $artist): void
    {
        if ($this->artists->contains($artist)) {
            $this->artists->removeElement($artist);
        }
    }

    public function __toString(): string
    {
        return substr(strrchr($this::class, '\\'), 1) . ':' . $this->id->value();
    }

    public function equals(self $album): bool
    {
        return
            $this->id->value() === $album->id->value() &&
            $this->title->value() === $album->title->value() &&
            $this->releaseDate->value()
            ===
            $album->releaseDate->value();
    }
}
