<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Event\EventPublisher;

final class AlbumCreator implements ApplicationService
{
    public function __construct(private AlbumRepository $albumRepository, private EventPublisher $publisher)
    {
    }

    /**
     * @throws \Masfernandez\MusicLabel\Catalog\Domain\Album\Exception\AlbumAlreadyExists
     */
    public function execute(PostAlbumCommand|Request $request): ?Response
    {
        $album = Album::create(
            id:             $request->getId(),
            title:          $request->getTitle(),
            releaseDate: $request->getPublishingDate(),
        );
        $this->albumRepository->post($album);
        $this->publisher->publish(...$album->dropEvents());
        return null;
    }
}
