<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;

class AlbumCreatedDomainEventMother
{
    public static function create(
        ?AlbumId $id = null,
        AlbumTitle $title = null,
        AlbumReleaseDate $releaseDate = null,
    ): AlbumCreatedDomainEvent {
        return new AlbumCreatedDomainEvent(
            id:              $id?->value() ?? AlbumIdMother::create()->value(),
            title:           $title->value(),
            release_date: $releaseDate->value(),
            eventId:         null,
            eventDate:       null,
        );
    }
}
