<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumRepository;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Service\AlbumFinder;
use Mockery;
use PHPUnit\Framework\TestCase;

class AlbumFinderTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldSearchAnAlbum(): void
    {
        $id            = AlbumIdMother::create();
        $albumExpected = AlbumMother::create(
            id: $id
        );

        // mocks
        $albumRepository = Mockery::mock(AlbumRepository::class);
        $albumRepository->allows()->search($id)->andReturns($albumExpected);

        // domain service
        $albumActual = (new AlbumFinder($albumRepository))->findById($id);
        self::assertEquals($albumExpected, $albumActual);
    }
}
