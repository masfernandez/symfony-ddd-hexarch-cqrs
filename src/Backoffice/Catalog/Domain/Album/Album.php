<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Event\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\AggregateRoot;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;
use ReflectionClass;
use Stringable;

class Album extends AggregateRoot implements Stringable
{
    final public const ID               = 'id';
    final public const TITLE            = 'title';
    final public const RELEASED_AT_DATE = 'releasedAtDate';
    final public const PRICE            = 'price';

    private Collection $tracks;
    private Collection $artists;

    /**
     * @param AlbumTrack[] $tracks
     * @param AlbumArtist[] $artists
     */
    private function __construct(
        private readonly AlbumId $id,
        private AlbumTitle $title,
        private AlbumReleasedAtDate $releasedAtDate,
        private readonly AlbumPrice $price,
        private ?LabelId $labelId,
        array $tracks,
        array $artists,
    ) {
        $this->tracks = new ArrayCollection();
        foreach ($tracks as $track) {
            $this->tracks->add($track);
        }

        $this->artists = new ArrayCollection();
        foreach ($artists as $artist) {
            $this->artists->add($artist);
        }

        $this->collectEvent(
            new AlbumCreatedDomainEvent(
                id:           $id->value(),
                title:        $title->value(),
                release_date: $releasedAtDate->value()->format(DATE_W3C),
            )
        );
    }

    /**
     * @param AlbumTrack[]|null $tracks
     * @param AlbumArtist[]|null $artists
     */
    public static function create(
        AlbumId $id,
        AlbumTitle $title,
        AlbumReleasedAtDate $releasedAtDate,
        AlbumPrice $price,
        ?LabelId $labelId = null,
        ?array $tracks = [],
        ?array $artists = [],
    ): Album {
        return new self(
            id:             $id,
            title:          $title,
            releasedAtDate: $releasedAtDate,
            price:          $price,
            labelId:        $labelId,
            tracks:         $tracks,
            artists:        $artists,
        );
    }

    public function getId(): AlbumId
    {
        return $this->id;
    }

    public function getTitle(): AlbumTitle
    {
        return $this->title;
    }

    public function getReleasedAtDate(): AlbumReleasedAtDate
    {
        return $this->releasedAtDate;
    }

    public function getTracks(): ArrayCollection
    {
        return $this->tracks;
    }

    public function getArtists(): ArrayCollection
    {
        return $this->artists;
    }

    public function getLabelId(): ?LabelId
    {
        return $this->labelId;
    }

    public function getPrice(): AlbumPrice
    {
        return $this->price;
    }

    public function addLabelId(LabelId $labelId): void
    {
        $this->labelId = $labelId;
    }

    /**
     * @return string[]
     */
    public static function getFieldNames(): array
    {
        return [
            self::ID,
            self::TITLE,
            self::RELEASED_AT_DATE
        ];
    }

    public function update(
        ?AlbumTitle $title,
        ?AlbumReleasedAtDate $releasedAtDate
    ): void {
        $this->title          = $title ?: $this->title;
        $this->releasedAtDate = $releasedAtDate ?: $this->releasedAtDate;
    }

    public function equals(self $album): bool
    {
        $id             = $this->id->value() === $album->id->value();
        $title          = $this->title->value() === $album->title->value();
        $releasedAtDate = $this->releasedAtDate->value() == $album->releasedAtDate->value();

        return $id && $title && $releasedAtDate;
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->id->value()}";
    }
}
