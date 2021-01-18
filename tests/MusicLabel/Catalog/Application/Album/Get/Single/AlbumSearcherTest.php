<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\AlbumSearcher;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumRepository;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\InMemoryRepository;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumSearcherTest extends TestCase
{
    /**
     * @test
     * @noinspection PhpUndefinedMethodInspection
     */
    public function itShouldSearchAnAlbum(): void
    {
        $query = GetAlbumQueryMother::create();
        $album = AlbumMother::create(id: $query->id());

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($query->id())->andReturns($album);

        $inMemoryRepository = Mockery::mock(InMemoryRepository::class);
        $inMemoryRepository->expects()
            ->get($query->id()->toString())
            ->andReturns(json_encode($album->toArray(), JSON_THROW_ON_ERROR));

        $actualResponse = (new AlbumSearcher($albumRepository, $inMemoryRepository))->execute($query);
        self::assertEquals(new AlbumResponse($album->toArray()), $actualResponse);
    }
}
