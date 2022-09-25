<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumTitleMother
{
    public static function create(
        ?string $value = null,
    ): AlbumTitle {
        return new AlbumTitle(
            $value ?? FakerMother::random()->word(),
        );
    }
}
