<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumReleasedAtDate;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineDateTimeType;

final class DoctrineAlbumReleasedAtDate extends DoctrineDateTimeType
{
    protected function getFQCN(): string
    {
        return AlbumReleasedAtDate::class;
    }
}
