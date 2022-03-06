<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumDeleter implements ApplicationService
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    /** @throws AlbumNotFound */
    public function execute(DeleteAlbumCommand|Request $request): ?Response
    {
        $album = $this->repository->getById(id: $request->id()) ?? throw new AlbumNotFound();

        $this->repository->delete(
            album: $album,
        );
        return null;
    }
}
