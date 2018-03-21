<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumsResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection\AlbumsSearcher;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumResultSet;
use Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\CriteriaMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumsSearcherTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSearchAlbums(): void
    {
        $query = GetAlbumsQueryMother::create();
        $album1 = AlbumMother::create();
        $album2 = AlbumMother::create();
        $album3 = AlbumMother::create();
        $album4 = AlbumMother::create();
        $criteria = CriteriaMother::create(
            $query->getFilters(),
            $query->getSort(),
            $query->getPage(),
            $query->getSize(),
            $query->getFields()
        );

        $albums = [$album1, $album2, $album3, $album4];
        $resultSet = new AlbumResultSet(
            $albums,
            count($albums),
            $criteria->getFieldsToFilter()
        );

        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getMatching(Mockery::any())->andReturns($resultSet);

        $expectedResponse = new AlbumsResponse(
            $resultSet->getAlbums(),
            $resultSet->getTotal(),
            $query->getPage(),
            $query->getSize()
        );

        $actualResponse = (new AlbumsSearcher($albumRepository))->execute($query);
        self::assertEquals($expectedResponse, $actualResponse);
    }
}
