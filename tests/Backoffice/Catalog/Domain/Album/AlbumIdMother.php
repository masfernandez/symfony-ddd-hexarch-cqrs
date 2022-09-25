<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;
use Masfernandez\ValueObject\ValueObjectException;

class AlbumIdMother
{
    /**
     * @throws ValueObjectException
     */
    public static function create(
        ?string $id = null,
    ): AlbumId {
        return new AlbumId(
            value: $id ?? FakerMother::random()->uuid(),
        );
    }
}
