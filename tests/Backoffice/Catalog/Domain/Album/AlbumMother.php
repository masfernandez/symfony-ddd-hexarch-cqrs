<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;

class AlbumMother
{
    public static function create(
        ?AlbumId $id = null,
        ?AlbumTitle $title = null,
        ?AlbumReleasedAtDate $releasedAtDate = null,
        ?AlbumPrice $price = null,
    ): Album {
        return Album::create(
            id:             $id ?? AlbumIdMother::create(),
            title:          $title ?? AlbumTitleMother::create(),
            releasedAtDate: $releasedAtDate ?? AlbumReleaseDateMother::create(),
            price:          $price ?? AlbumPriceMother::create(),
        );
    }
}
