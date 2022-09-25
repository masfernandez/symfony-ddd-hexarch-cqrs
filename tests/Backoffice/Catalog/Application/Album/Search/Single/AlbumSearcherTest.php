<?php

/** @noinspection PhpUndefinedMethodInspection */

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single\AlbumResponse;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Single\AlbumSearcher;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
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
        $albumRepository->allows()->search($query->id())->andReturns($album);

        $actualResponse   = (new AlbumSearcher($albumRepository))->execute($query);
        $expectedResponse = new AlbumResponse(AlbumAssembler::fromEntityToResponse($album));
        self::assertEquals($expectedResponse, $actualResponse);
    }
}
