<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\GetAlbumQuery;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumIdMother;

class GetAlbumQueryMother
{
    public static function create(
        ?string $id = null,
    ): GetAlbumQuery {
        return new GetAlbumQuery(
            id: $id ?? AlbumIdMother::create()->value(),
        );
    }
}
