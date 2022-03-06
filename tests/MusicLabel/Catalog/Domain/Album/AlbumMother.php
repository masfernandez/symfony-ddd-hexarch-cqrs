<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;

class AlbumMother
{
    public static function create(
        ?AlbumId $id = null,
        ?AlbumTitle $title = null,
        ?\Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate $releaseDate = null,
    ): Album {
        return Album::create(
            id:             $id ?? AlbumIdMother::create(),
            title:          $title ?? AlbumTitleMother::create(),
            releaseDate: $releaseDate ?? AlbumReleaseDateMother::create(),
        );
    }
}
