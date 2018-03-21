<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Shared\Domain\Model\Album\AlbumId;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumIdMother
{
    public static function create(?string $value = null): AlbumId
    {
        return new AlbumId($value ?? FakerMother::random()->uuid);
    }
}
