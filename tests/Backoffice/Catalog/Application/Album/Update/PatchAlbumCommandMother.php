<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Update;

use Exception;
use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Update\UpdateAlbumCommand;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumTitleMother;

class PatchAlbumCommandMother
{
    /**
     * @throws Exception
     */
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $releasedAtDate = null,
    ): UpdateAlbumCommand {
        return new UpdateAlbumCommand(
            id:             $id ?? AlbumIdMother::create()->value(),
            title:          $title ?? AlbumTitleMother::create()->value(),
            releasedAtDate: $releasedAtDate ?? AlbumReleaseDateMother::create()->value()->format(DATE_W3C),
        );
    }
}
