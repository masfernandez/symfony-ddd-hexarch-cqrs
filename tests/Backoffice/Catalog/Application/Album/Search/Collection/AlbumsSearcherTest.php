<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection\AlbumsResponse;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection\AlbumsSearcher;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumResultSet;
use Masfernandez\Tests\MusicLabel\Shared\Application\CriteriaMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumsSearcherTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSearchAlbumsAsArray(): void
    {
        $query  = GetAlbumsQueryMother::create();
        $album1 = AlbumMother::create();
        $album2 = AlbumMother::create();
        $album3 = AlbumMother::create();
        $album4 = AlbumMother::create();

        $albums    = [
            AlbumAssembler::fromEntityToArray($album1),
            AlbumAssembler::fromEntityToArray($album2),
            AlbumAssembler::fromEntityToArray($album3),
            AlbumAssembler::fromEntityToArray($album4),
        ];
        $resultSet = new AlbumResultSet(
            albums: $albums,
            total:  count($albums),
        );

        CriteriaMother::create(
            exp:  $query->getFilters(),
            sort: $query->getSort(),
            page: $query->getPage(),
            size: $query->getSize(),
        );

        SelectMother::create(
            fields: $query->getFields(),
        );

        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getMatching(Mockery::any(), Mockery::any())->andReturns($resultSet);

        $expectedResponse = new AlbumsResponse(
            albums: $resultSet->getAlbums(),
            total:  $resultSet->getTotal(),
            page:   $query->getPage(),
            size:   $query->getSize()
        );

        $actualResponse = (new AlbumsSearcher($albumRepository))->execute($query);
        self::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldSearchAlbumsAsEntity(): void
    {
        $query  = GetAlbumsQueryMother::create();
        $album1 = AlbumMother::create();
        $album2 = AlbumMother::create();
        $album3 = AlbumMother::create();
        $album4 = AlbumMother::create();

        $albums    = [$album1, $album2, $album3, $album4];
        $resultSet = new AlbumResultSet(
            albums: $albums,
            total:  count($albums),
        );

        CriteriaMother::create(
            exp:  $query->getFilters(),
            sort: $query->getSort(),
            page: $query->getPage(),
            size: $query->getSize(),
        );

        SelectMother::create(
            fields: $query->getFields(),
        );

        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getMatching(Mockery::any(), Mockery::any())->andReturns($resultSet);

        $expectedResponse = new AlbumsResponse(
            albums: $resultSet->getAlbums(),
            total:  $resultSet->getTotal(),
            page:   $query->getPage(),
            size:   $query->getSize()
        );

        $actualResponse = (new AlbumsSearcher($albumRepository))->execute($query);
        self::assertEquals($expectedResponse, $actualResponse);
    }
}
