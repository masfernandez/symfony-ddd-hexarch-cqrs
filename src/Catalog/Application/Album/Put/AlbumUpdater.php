<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumUpdater implements ApplicationService
{
    public function __construct(private readonly AlbumRepository $repository)
    {
    }

    /** @throws AlbumNotFound */
    public function execute(PutAlbumCommand|Request $request): ?Response
    {
        $album = $this->repository->getById($request->getId()) ??
            throw new AlbumNotFound();

        $album->update(
            $request->getTitle(),
            $request->getPublishingDate(),
        );
        $this->repository->put($album);
        return null;
    }
}
