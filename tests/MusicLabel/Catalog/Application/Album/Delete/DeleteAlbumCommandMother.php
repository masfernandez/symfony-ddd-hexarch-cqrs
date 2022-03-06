<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Catalog\Application\Album\Delete\DeleteAlbumCommand;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumIdMother;

class DeleteAlbumCommandMother
{
    public static function create(
        ?string $id = null,
    ): DeleteAlbumCommand {
        return new DeleteAlbumCommand(
            id: $id ?? AlbumIdMother::create()->value(),
        );
    }
}
