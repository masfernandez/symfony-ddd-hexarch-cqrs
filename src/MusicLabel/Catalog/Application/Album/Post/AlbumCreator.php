<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExistsException;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisherInterface;
use Masfernandez\Shared\Domain\Bus\Request\RequestInterface;

final class AlbumCreator implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $repository, private EventPublisherInterface $publisher)
    {
    }

    /**
     * @throws AlbumAlreadyExistsException
     */
    public function execute(PostAlbumCommand | RequestInterface $request): void
    {
        $album = new Album(
            $request->getId(),
            $request->getTitle(),
            $request->getPublishingDate()
        );
        $this->repository->post($album);
        $this->publisher->publish(...$album->dropEvents());
    }
}
