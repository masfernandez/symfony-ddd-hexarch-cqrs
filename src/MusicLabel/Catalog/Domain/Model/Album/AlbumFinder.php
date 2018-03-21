<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;

final class AlbumFinder
{
    public function __construct(private AlbumRepository $albumRepository)
    {
    }

    public function findById(AlbumId $id): ?Album
    {
        return $this->albumRepository->getById($id);
    }
}
