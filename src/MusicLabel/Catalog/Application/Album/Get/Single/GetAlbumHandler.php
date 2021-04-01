<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Query\QueryHandler;

final class GetAlbumHandler implements QueryHandler
{
    public function __construct(private ApplicationServiceInterface $albumSearcher)
    {
    }

    public function __invoke(GetAlbumQuery $query): AlbumResponse
    {
        return $this->albumSearcher->execute($query);
    }
}
