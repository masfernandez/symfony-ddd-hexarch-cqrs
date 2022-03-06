<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumReleaseDate;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumReleaseDateMother
{
    public static function create(
        ?string $value = null,
    ): AlbumReleaseDate {
        return new AlbumReleaseDate(
            value: $value ?? FakerMother::random()->dateTime()->format(AlbumReleaseDate::FORMAT),
        );
    }
}
