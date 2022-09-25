<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\ValueObject\TrackPrice;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineFloatType;

final class DoctrineTrackPrice extends DoctrineFloatType
{
    protected function getFQCN(): string
    {
        return TrackPrice::class;
    }
}
