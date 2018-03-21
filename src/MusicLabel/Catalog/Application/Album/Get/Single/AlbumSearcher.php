<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\RequestInterface;

final class AlbumSearcher implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    public function execute(GetAlbumQuery | RequestInterface $request): AlbumResponse
    {
        $album = $this->repository->getById($request->id());
        $albumArray = ($album !== null) ? $album->toArray() : [];
        return new AlbumResponse($albumArray);
    }
}
