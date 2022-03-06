<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\Criteria;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Select;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class AlbumsSearcher implements ApplicationService
{
    public function __construct(private AlbumRepository $repository)
    {
    }

    public function execute(GetAlbumsQuery|Request $request): AlbumsResponse
    {
        $alias    = 'album';
        $criteria = new Criteria(
            exp:   $request->getFilters(), //@todo not implemented
            sort:  $request->getSort(),
            page:  $request->getPage(),
            size:  $request->getSize(),
            alias: $alias
        );

        $select = new Select(
            fields:     $request->getFields(),
            alias:      $alias,
            fetchArray: true,
        );

        $albumResultSet = $this->repository->getMatching(
            select:   $select,
            criteria: $criteria
        );

        return new AlbumsResponse(
            albums: $albumResultSet->getAlbums(),
            total:  $albumResultSet->getTotal(),
            page:   $request->getPage(),
            size:   $request->getSize(),
        );
    }
}
