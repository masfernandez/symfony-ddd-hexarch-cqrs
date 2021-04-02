<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExists;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisher;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumCreator implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $albumRepository, private EventPublisher $publisher)
    {
    }

    /**
     * @throws AlbumAlreadyExists
     */
    public function execute(PostAlbumCommand | Request $request): void
    {
        $album = new Album(
            $request->getId(),
            $request->getTitle(),
            $request->getPublishingDate()
        );
        $this->albumRepository->post($album);
        $this->publisher->publish(...$album->dropEvents());
    }
}
