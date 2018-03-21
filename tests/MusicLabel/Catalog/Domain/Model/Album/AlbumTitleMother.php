<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\MusicLabel\Catalog\Domain\Model\Album\AlbumTitle;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumTitleMother
{
    public static function create(?string $value = null): AlbumTitle
    {
        return new AlbumTitle($value ?? FakerMother::random()->word);
    }
}
