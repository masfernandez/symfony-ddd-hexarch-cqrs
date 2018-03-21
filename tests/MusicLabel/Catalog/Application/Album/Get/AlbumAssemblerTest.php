<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\Album;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumTitleMother;
use PHPUnit\Framework\TestCase;

class AlbumAssemblerTest extends TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAnAlbum(): void
    {
        $album = AlbumAssembler::fromArray(
            [
                Album::ID => AlbumIdMother::create()->value(),
                Album::TITLE => AlbumTitleMother::create()->value(),
                Album::PUBLISHING_DATE => AlbumPublishingDateMother::create()->value()
            ]
        );
        // unnecessary asserting not null
    }

    /**
     * @test
     */
    public function itShouldReturnAnArray(): void
    {
        $array = AlbumAssembler::toArray(AlbumMother::create());
        // unnecessary asserting not null
    }
}
