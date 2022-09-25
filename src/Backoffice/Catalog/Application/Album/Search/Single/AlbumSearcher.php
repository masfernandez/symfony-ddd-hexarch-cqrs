<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class AlbumSearcher implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
    ) {
    }

    public function execute(SearchAlbumQuery|Request $request): AlbumResponse
    {
        $album = $this->albumRepository->search(
            id: $request->id(),
        );

        $albumArray = ($album !== null) ? AlbumAssembler::fromEntityToResponse($album) : [];

        return new AlbumResponse($albumArray);
    }
}
