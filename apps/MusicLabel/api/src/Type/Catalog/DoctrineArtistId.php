<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineUuidType;
use Masfernandez\MusicLabel\Shared\Domain\Id\ArtistId;

final class DoctrineArtistId extends DoctrineUuidType
{
    protected function getFQCN(): string
    {
        return ArtistId::class;
    }
}
