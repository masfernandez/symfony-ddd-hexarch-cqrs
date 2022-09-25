<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Event\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;

class AlbumCreatedDomainEventMother
{
    public static function create(
        ?AlbumId $id = null,
        AlbumTitle $title = null,
        AlbumReleasedAtDate $releasedAtDate = null,
    ): AlbumCreatedDomainEvent {
        return new AlbumCreatedDomainEvent(
            id:           $id?->value() ?? AlbumIdMother::create()->value(),
            title:        $title->value(),
            release_date: $releasedAtDate->value()->format(DATE_W3C),
            eventId:      null,
            eventDate:    null,
        );
    }
}
