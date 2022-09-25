<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Replace;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Replace\ReplaceAlbumCommand;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumTitleMother;

class PutAlbumCommandMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $release_date = null,
    ): ReplaceAlbumCommand {
        return new ReplaceAlbumCommand(
            id:             $id ?? AlbumIdMother::create()->value(),
            title:          $title ?? AlbumTitleMother::create()->value(),
            releasedAtDate: $release_date ?? AlbumReleaseDateMother::create()->value()->format(DATE_W3C),
        );
    }
}
