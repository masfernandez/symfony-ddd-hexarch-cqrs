<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Post;

use Masfernandez\MusicLabel\Catalog\Application\Album\Post\PostAlbumCommand;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token\TokenValueMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumPublishingDateMother;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumTitleMother;

class PostAlbumCommandMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $publishing_date = null,
        ?string $token = null
    ): PostAlbumCommand {
        return new PostAlbumCommand(
            $id ?? AlbumIdMother::create()->value(),
            $title ?? AlbumTitleMother::create()->value(),
            $publishing_date ?? AlbumPublishingDateMother::create()->value(),
            $token ?? TokenValueMother::create()->value()
        );
    }
}
