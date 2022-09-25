<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\ValueObject\TrackName;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineStringType;

final class DoctrineTrackName extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return TrackName::class;
    }
}
