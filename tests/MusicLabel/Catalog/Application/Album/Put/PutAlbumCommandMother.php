<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Put;

use Masfernandez\MusicLabel\Catalog\Application\Album\Put\PutAlbumCommand;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumTitleMother;

class PutAlbumCommandMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $publishing_date = null
    ): PutAlbumCommand {
        return new PutAlbumCommand(
            $id ?? AlbumIdMother::create()->value(),
            $title ?? AlbumTitleMother::create()->value(),
            $publishing_date ?? AlbumPublishingDateMother::create()->value()
        );
    }
}
