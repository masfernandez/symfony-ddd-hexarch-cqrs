<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\PutAlbumCommand;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumTitleMother;

class PutAlbumCommandMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $release_date = null,
    ): PutAlbumCommand {
        return new PutAlbumCommand(
            id:             $id ?? AlbumIdMother::create()->value(),
            title:          $title ?? AlbumTitleMother::create()->value(),
            releaseDate: $release_date ?? AlbumReleaseDateMother::create()->value(),
        );
    }
}
