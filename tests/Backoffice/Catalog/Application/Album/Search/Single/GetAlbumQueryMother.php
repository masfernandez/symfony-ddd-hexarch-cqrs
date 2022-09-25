<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single\SearchAlbumQuery;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumIdMother;

class GetAlbumQueryMother
{
    public static function create(
        ?string $id = null,
    ): SearchAlbumQuery {
        return new SearchAlbumQuery(
            id: $id ?? AlbumIdMother::create()->value(),
        );
    }
}
