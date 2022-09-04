<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class AlbumSearcher implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository
    ) {
    }

    public function execute(GetAlbumQuery|Request $request): AlbumResponse
    {
        $album = $this->albumRepository->getById(
            id: $request->id()
        );

        $albumArray = ($album !== null) ? AlbumAssembler::fromEntityToResponse($album) : [];

        return new AlbumResponse($albumArray);
    }
}
