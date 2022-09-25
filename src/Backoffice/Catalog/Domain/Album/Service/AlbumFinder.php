<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Service;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;

final class AlbumFinder
{
    public function __construct(
        private readonly AlbumRepository $albumRepository
    ) {
    }

    public function findById(AlbumId $id): ?Album
    {
        return $this->albumRepository->search($id);
    }
}
