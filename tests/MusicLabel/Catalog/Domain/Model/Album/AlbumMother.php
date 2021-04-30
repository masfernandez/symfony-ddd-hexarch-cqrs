<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDate;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;

class AlbumMother
{
    public static function create(
        ?AlbumId $id = null,
        ?AlbumTitle $title = null,
        ?AlbumPublishingDate $publishingDate = null
    ): Album {
        return Album::create(
            $id ?? AlbumIdMother::create(),
            $title ?? AlbumTitleMother::create(),
            $publishingDate ?? AlbumPublishingDateMother::create()
        );
    }
}
