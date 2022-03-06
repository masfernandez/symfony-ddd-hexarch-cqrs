<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Application\Album\Post\PostAlbumCommand;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token\TokenValueMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Album\AlbumTitleMother;

class PostAlbumCommandMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $releaseDate = null,
        ?string $token = null,
    ): PostAlbumCommand {
        return new PostAlbumCommand(
            id:             $id ?? AlbumIdMother::create()->value(),
            title:          $title ?? AlbumTitleMother::create()->value(),
            releaseDate: $releaseDate ?? AlbumReleaseDateMother::create()->value(),
            token:          $token ?? TokenValueMother::create()->value(),
        );
    }
}
