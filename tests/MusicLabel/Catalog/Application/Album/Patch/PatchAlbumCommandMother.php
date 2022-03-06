<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Patch;

use Exception;
use Masfernandez\MusicLabel\Catalog\Application\Album\Patch\PatchAlbumCommand;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Album;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumTitleMother;

class PatchAlbumCommandMother
{
    /**
     * @throws Exception
     */
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $releaseDate = null,
    ): PatchAlbumCommand {
        return new PatchAlbumCommand(
            id:             $id ?? AlbumIdMother::create()->value(),
            title:          $title ?? AlbumTitleMother::create()->value(),
            releaseDate: $releaseDate ?? AlbumReleaseDateMother::create()->value(),
        );
    }
}
