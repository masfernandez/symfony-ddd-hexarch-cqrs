<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Single;

use Masfernandez\MusicLabel\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\AlbumResponse;
use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Single\AlbumSearcher;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumMother;
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

        $actualResponse   = (new AlbumSearcher($albumRepository))->execute($query);
        $expectedResponse = new AlbumResponse(AlbumAssembler::fromEntityToResponse($album));
        self::assertEquals($expectedResponse, $actualResponse);
    }
}
