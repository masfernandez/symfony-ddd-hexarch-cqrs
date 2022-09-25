<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Replace;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumReplacer implements ApplicationService
{
    public function __construct(private readonly AlbumRepository $repository)
    {
    }

    /** @throws AlbumNotFound */
    public function execute(ReplaceAlbumCommand|Request $request): ?Response
    {
        $album = $this->repository->search($request->getId()) ??
            throw new AlbumNotFound();

        $album->update(
            $request->getTitle(),
            $request->getPublishingDate(),
        );
        $this->repository->update($album);

        return null;
    }
}
