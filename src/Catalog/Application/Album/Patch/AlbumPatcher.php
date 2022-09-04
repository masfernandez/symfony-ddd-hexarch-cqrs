<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumPatcher implements ApplicationService
{
    public function __construct(private readonly AlbumRepository $repository)
    {
    }

    /** @throws AlbumNotFound */
    public function execute(PatchAlbumCommand|Request $request): ?Response
    {
        $album = $this->repository->getById(id: $request->getId()) ??
            throw new AlbumNotFound();

        $album->update(
            title:          $request->getTitle(),
            releaseDate: $request->getPublishingDate(),
        );
        $this->repository->patch($album);

        return null;
    }
}
