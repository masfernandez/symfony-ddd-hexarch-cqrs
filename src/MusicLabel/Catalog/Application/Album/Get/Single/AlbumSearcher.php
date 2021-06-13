<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumSearcher implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $albumRepository)
    {
    }

    public function execute(GetAlbumQuery|Request $request): AlbumResponse
    {
        $album      = $this->albumRepository->getById($request->id());
        $albumArray = ($album !== null) ? $album->toArray() : [];

        return new AlbumResponse($albumArray);
    }
}
