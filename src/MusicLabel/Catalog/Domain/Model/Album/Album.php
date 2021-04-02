<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Artist\Artist;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\Shared\Domain\Bus\Event\DomainEvent;
use Masfernandez\Shared\Domain\Model\Aggregate;
use Stringable;

// Cannot be final cause: Unable to create a proxy for a final exception
// It doesn't mean is open to inheritance...
class Album extends Aggregate implements Stringable
{
    public const ID = 'id';
    public const TITLE = 'title';
    public const PUBLISHING_DATE = 'publishing_date';
    private Collection $artists;

    // phpcs:disable
    public function __construct(
        private AlbumId $id,
        private AlbumTitle $title,
        private AlbumPublishingDate $publishing_date
    )
    {
        $this->artists = new ArrayCollection();
        $this->collectEvent(new AlbumCreatedDomainEvent(
            $id->value(),
            $title->value(),
            $publishing_date->value(),
            null,
            (new DateTime())->format(DomainEvent::$dateFormat)
        ));
    }
    // phpcs:enable

    public static function fromArray(array $primitiveData): Album
    {
        return new self(
            new AlbumId($primitiveData[self::ID]),
            new AlbumTitle($primitiveData[self::TITLE]),
            new AlbumPublishingDate($primitiveData[self::PUBLISHING_DATE]),
        );
    }

    /**
     * @return string[]
     */
    public static function getFieldNames(): array
    {
        return [
            self::ID,
            self::TITLE,
            self::PUBLISHING_DATE
        ];
    }

    /**
     * @return array<string, mixed[]|string>
     */
    public function toArray(): array
    {
        return [
            self::ID => $this->id->value(),
            self::TITLE => $this->title->value(),
            self::PUBLISHING_DATE => $this->publishing_date->value(),
        ];
    }

    public function update(?AlbumTitle $title, ?AlbumPublishingDate $publishing_date): void
    {
        $this->title = $title ?: $this->title;
        $this->publishing_date = $publishing_date ?: $this->publishing_date;
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

    public function compareToAlbum(self $album): bool
    {
        return $this->id === $album->id &&
            $this->title === $album->title &&
            $this->publishing_date === $album->publishing_date &&
            $this->countEvents() === $album->countEvents();
    }

    public function __toString(): string
    {
        return $this::class . ':' . $this->id->value();
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }
}
