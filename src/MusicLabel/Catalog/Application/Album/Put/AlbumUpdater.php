<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Put;

use JsonException;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumNotFound;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\CacheInMemory;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumUpdater implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $repository, private CacheInMemory $cache)
    {
    }

    /** @throws AlbumNotFound|JsonException */
    public function execute(PutAlbumCommand | Request $request): void
    {
        $album = $this->repository->getById($request->getId()) ??
            throw new AlbumNotFound();

        $album->update(
            $request->getTitle(),
            $request->getPublishingDate(),
        );
        $this->repository->put($album);

        $this->cache->set(
            $request->getId()->toString(),
            json_encode($album->toArray(), JSON_THROW_ON_ERROR)
        );
    }
}
