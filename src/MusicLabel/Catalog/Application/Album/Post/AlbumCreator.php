<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\InvalidCredentials;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumAlreadyExistsException;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Event\EventPublisherInterface;
use Masfernandez\Shared\Domain\Bus\Request\RequestInterface;

final class AlbumCreator implements ApplicationServiceInterface
{
    public function __construct(
        private AlbumRepository $albumRepository,
        private EventPublisherInterface $publisher,
        private TokenRepository $tokenRepository
    )
    {
    }

    /**
     * @throws AlbumAlreadyExistsException|InvalidCredentials
     */
    public function execute(PostAlbumCommand|RequestInterface $request): void
    {
        $this->tokenRepository->getByValue($request->getToken()) ??
            throw new InvalidCredentials();

        $album = new Album(
            $request->getId(),
            $request->getTitle(),
            $request->getPublishingDate()
        );
        $this->albumRepository->post($album);
        $this->publisher->publish(...$album->dropEvents());
    }
}
