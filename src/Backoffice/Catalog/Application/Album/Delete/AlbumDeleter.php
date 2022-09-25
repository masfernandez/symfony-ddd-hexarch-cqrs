<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumDeleter implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
    ) {
    }

    /**
     * @throws AlbumNotFound
     */
    public function execute(DeleteAlbumCommand|Request $request): ?Response
    {
        $album = $this->albumRepository->search(id: $request->id()) ??
            throw new AlbumNotFound();

        $this->albumRepository->remove(
            album: $album,
        );

        return null;
    }
}
