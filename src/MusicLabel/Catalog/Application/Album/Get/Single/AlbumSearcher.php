<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single;

use JsonException;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\CacheInMemory;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumSearcher implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $albumRepository, private CacheInMemory $cache)
    {
    }

    /** @throws JsonException */
    public function execute(GetAlbumQuery | Request $request): AlbumResponse
    {
        $cacheResponse = $this->cache->get($request->id()->toString());
        if ($cacheResponse !== false) {
            $albumArray = json_decode($cacheResponse, true, 512, JSON_THROW_ON_ERROR);
            return new AlbumResponse($albumArray);
        }

        $album = $this->albumRepository->getById($request->id());
        $albumArray = ($album !== null) ? $album->toArray() : [];
        $this->cache->set(
            $request->id()->toString(),
            json_encode($albumArray, JSON_THROW_ON_ERROR)
        );
        return new AlbumResponse($albumArray);
    }
}
