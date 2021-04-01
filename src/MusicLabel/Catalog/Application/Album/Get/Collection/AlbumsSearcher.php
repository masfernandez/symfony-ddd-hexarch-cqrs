<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumsResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Criteria;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class AlbumsSearcher implements ApplicationServiceInterface
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    public function execute(GetAlbumsQuery|Request $request): AlbumsResponse
    {
        $criteria = new Criteria(
            $request->getFilters(), //@todo not implemented
            $request->getSort(),
            $request->getPage(),
            $request->getSize(),
            $request->getFields()
        );
        $albumResultSet = $this->repository->getMatching($criteria);
        return new AlbumsResponse(
            $albumResultSet->getAlbums(),
            $albumResultSet->getTotal(),
            $request->getPage(),
            $request->getSize()
        );
    }
}
