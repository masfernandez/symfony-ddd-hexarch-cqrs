<?php

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Delete;

use Masfernandez\MusicLabel\Catalog\Application\Album\Delete\DeleteAlbumCommand;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumIdMother;

class DeleteAlbumCommandMother
{
    public static function create(?string $id = null): DeleteAlbumCommand
    {
        return new DeleteAlbumCommand(
            $id ?? AlbumIdMother::create()->value()
        );
    }
}
