<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Shared\Domain\Album;

use Masfernandez\MusicLabel\Shared\Domain\ValueObject\UuidValueObject;

final class AlbumId extends UuidValueObject
{
    public function toString(): string
    {
        return $this->toRfc4122();
    }
}
