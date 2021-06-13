<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Patch;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumPatcher implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    /** @throws AlbumNotFound */
    public function execute(PatchAlbumCommand|Request $request): void
    {
        $album = $this->repository->getById($request->getId()) ??
            throw new AlbumNotFound();

        $album->update(
            $request->getTitle(),
            $request->getPublishingDate(),
        );
        $this->repository->patch($album);
    }
}
