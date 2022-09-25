<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Shared\Domain\Id\AlbumId;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineUuidType;

final class DoctrineAlbumId extends DoctrineUuidType
{
    protected function getFQCN(): string
    {
        return AlbumId::class;
    }
}
