<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Shared\Domain\Album\AlbumId;

final class AlbumFinder
{
    public function __construct(private readonly AlbumRepository $albumRepository)
    {
    }

    public function findById(AlbumId $id): ?Album
    {
        return $this->albumRepository->getById($id);
    }
}
