<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumCreatedDomainEvent;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;

class AlbumCreatedDomainEventMother
{
    public static function create(
        ?AlbumId $id = null,
        ?AlbumTitle $title = null,
        ?AlbumPublishingDate $publishingDate = null
    ): AlbumCreatedDomainEvent {
        return new AlbumCreatedDomainEvent(
            $id?->value() ?? AlbumIdMother::create()->value(),
            $title?->value() ?? AlbumTitleMother::create()->value(),
            $publishingDate?->value() ?? AlbumPublishingDateMother::create()->value(),
            null,
            null
        );
    }
}
