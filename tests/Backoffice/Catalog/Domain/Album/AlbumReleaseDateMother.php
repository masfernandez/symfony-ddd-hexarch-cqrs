<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use DateTimeZone;
use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumReleaseDateMother
{
    public static function create(
        ?string $value = null,
    ): AlbumReleasedAtDate {
        return new AlbumReleasedAtDate(
            value: $value ?? FakerMother::random()->dateTime()->setTimezone(new DateTimeZone('UTC'))->format(DATE_W3C),
        );
    }
}
