<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumsResponse;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Query\QueryHandler;

final class GetAlbumsHandler implements QueryHandler
{
    public function __construct(private ApplicationServiceInterface $albumsSearcher)
    {
    }

    public function __invoke(GetAlbumsQuery $query): AlbumsResponse
    {
        return $this->albumsSearcher->execute($query);
    }
}
