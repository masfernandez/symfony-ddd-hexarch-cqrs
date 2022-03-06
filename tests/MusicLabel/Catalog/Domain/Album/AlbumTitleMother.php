<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumTitleMother
{
    public static function create(
        ?string $value = null,
    ): AlbumTitle {
        return new \Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject\AlbumTitle(
            $value ?? FakerMother::random()->word(),
        );
    }
}
