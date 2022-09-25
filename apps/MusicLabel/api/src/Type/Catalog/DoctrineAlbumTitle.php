<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumTitle;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineStringType;

final class DoctrineAlbumTitle extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return AlbumTitle::class;
    }
}
