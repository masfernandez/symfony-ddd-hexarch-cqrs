<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumFinder;
use Masfernandez\MusicLabel\Catalog\Domain\Album\AlbumRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumFinderTest extends TestCase
{
    /**
     * @test
     * @noinspection PhpUndefinedMethodInspection
     */
    public function itShouldSearchAnAlbum(): void
    {
        $id            = AlbumIdMother::create();
        $albumExpected = AlbumMother::create(
            id: $id
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->getById($id)->andReturns($albumExpected);

        // domain service
        $albumActual = (new AlbumFinder($albumRepository))->findById($id);
        self::assertEquals($albumExpected, $albumActual);
    }
}
