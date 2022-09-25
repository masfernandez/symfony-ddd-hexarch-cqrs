<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Update;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumNotFound;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumUpdater implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
    ) {
    }

    /** @throws AlbumNotFound */
    public function execute(UpdateAlbumCommand|Request $request): ?Response
    {
        $album = $this->albumRepository->search(id: $request->getId()) ??
            throw new AlbumNotFound();

        $album->update(
            title:          $request->getTitle(),
            releasedAtDate: $request->getPublishingDate(),
        );

        $this->albumRepository->update($album);

        return null;
    }
}
