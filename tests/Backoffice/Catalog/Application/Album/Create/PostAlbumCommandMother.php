<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Create;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Create\CreateAlbumCommand;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\TokenValueMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumIdMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumPriceMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumReleaseDateMother;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumTitleMother;

class PostAlbumCommandMother
{
    public static function create(
        ?string $id = null,
        ?string $title = null,
        ?string $releasedAtDate = null,
        ?float $price = null,
        ?string $token = null,
    ): CreateAlbumCommand {
        return new CreateAlbumCommand(
            id:             $id ?? AlbumIdMother::create()->value(),
            title:          $title ?? AlbumTitleMother::create()->value(),
            releasedAtDate: $releasedAtDate ?? AlbumReleaseDateMother::create()->value()->format(DATE_W3C),
            price:          $price ?? AlbumPriceMother::create()->value(),
            token:          $token ?? TokenValueMother::create()->value(),
        );
    }
}
