<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumAssembler;

final class AlbumResultSet
{
    private array $albums;

    /**
     * @param Album[] $albums
     */
    public function __construct(array $albums, private int $total, array $fields)
    {
        $this->albums = [];
        foreach ($albums as $album) {
            $albumArray     = AlbumAssembler::toArray($album);
            $this->albums[] = array_intersect_key($albumArray, array_flip($fields));
        }
    }

    /**
     * @return mixed[]
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
