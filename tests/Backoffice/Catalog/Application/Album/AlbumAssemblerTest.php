<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumPriceMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumTitleMother;
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
                Album::ID               => AlbumIdMother::create()->value(),
                Album::TITLE            => AlbumTitleMother::create()->value(),
                Album::RELEASED_AT_DATE => AlbumReleaseDateMother::create()->value()->format(DATE_W3C),
                Album::PRICE            => AlbumPriceMother::create()->value(),
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
