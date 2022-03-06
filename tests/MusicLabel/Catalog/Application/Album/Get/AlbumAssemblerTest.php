<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get;

use Masfernandez\MusicLabel\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumTitleMother;
use PHPUnit\Framework\TestCase;

class AlbumAssemblerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnAlbum(): void
    {
        AlbumAssembler::fromArrayPrimitivesToEntity(
            [
                Album::ID              => AlbumIdMother::create()->value(),
                Album::TITLE           => AlbumTitleMother::create()->value(),
                Album::RELEASE_DATE => AlbumReleaseDateMother::create()->value()
            ]
        );
    }

    /**
     * @test
     */
    public function itShouldReturnAnArray(): void
    {
        AlbumAssembler::fromEntityToArray(AlbumMother::create());
    }
}
