<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\ValueObject\AlbumPrice;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineFloatType;

class DoctrineAlbumPrice extends DoctrineFloatType
{
    protected function getFQCN(): string
    {
        return AlbumPrice::class;
    }
}