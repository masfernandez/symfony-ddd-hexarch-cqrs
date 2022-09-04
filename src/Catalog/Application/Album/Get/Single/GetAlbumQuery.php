<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Query\SyncQuery;

final class GetAlbumQuery implements SyncQuery
{
    private readonly AlbumId $id;

    public function __construct(string $id)
    {
        $this->id = new AlbumId($id);
    }

    public function id(): AlbumId
    {
        return $this->id;
    }
}
