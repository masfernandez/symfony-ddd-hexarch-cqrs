<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Shared\Application\Criteria;
use Masfernandez\MusicLabel\Shared\Application\Select;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class AlbumsSearcher implements ApplicationService
{
    public function __construct(private readonly AlbumRepository $repository)
    {
    }

    public function execute(SearchAlbumsQuery|Request $request): AlbumsResponse
    {
        $alias    = 'album';
        $criteria = new Criteria(
            exp:   $request->getFilters(), // @todo not implemented
            sort:  $request->getSort(),
            page:  $request->getPage(),
            size:  $request->getSize(),
            alias: $alias,
        );

        $select = new Select(
            fields:     $request->getFields(),
            alias:      $alias,
            fetchArray: true,
        );

        $albumResultSet = $this->repository->getMatching(
            select:   $select,
            criteria: $criteria,
        );

        return new AlbumsResponse(
            albums: $albumResultSet->getAlbums(),
            total:  $albumResultSet->getTotal(),
            page:   $request->getPage(),
            size:   $request->getSize(),
        );
    }
}
