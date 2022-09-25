<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Create;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Exception\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\EventPublisher;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class AlbumCreator implements ApplicationService
{
    public function __construct(
        private readonly AlbumRepository $albumRepository,
        private readonly EventPublisher $publisher,
    ) {
    }

    /**
     * @throws AlbumAlreadyExists
     */
    public function execute(CreateAlbumCommand|Request $request): ?Response
    {
        $album = Album::create(
            id:             $request->getId(),
            title:          $request->getTitle(),
            releasedAtDate: $request->getReleasedAtDate(),
            price:          $request->getPrice(),
        );

        $this->albumRepository->add($album);
        $this->publisher->publish(...$album->dropEvents());

        return null;
    }
}
