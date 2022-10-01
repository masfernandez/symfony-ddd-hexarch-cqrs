<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Query\SyncQuery;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\ValueObject\Exception\ValueObjectException;

final class SearchAlbumQuery implements SyncQuery
{
    private readonly AlbumId $id;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $id,
    ) {
        $this->id = new AlbumId($id);
    }

    public function id(): AlbumId
    {
        return $this->id;
    }
}
