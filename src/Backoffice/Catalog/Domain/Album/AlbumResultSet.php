<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;

final class AlbumResultSet
{
    /**
     * @param Album[]|array $albums
     */
    public function __construct(
        private readonly array $albums,
        private readonly int $total
    ) {
    }

    /**
     * @return Album[]|array
     */
    public function getAlbums(): array
    {
        $albums = [];
        foreach ($this->albums as $album) {
            if ($album instanceof Album) {
                $albums[] = AlbumAssembler::fromEntityToResponse($album);
            } else {
                $albums[] = AlbumAssembler::fromArrayToResponse($album);
            }
        }
        return $albums;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
