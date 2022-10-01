<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineUuidType;
use Masfernandez\MusicLabel\Shared\Domain\Id\LabelId;

final class DoctrineLabelId extends DoctrineUuidType
{
    protected function getFQCN(): string
    {
        return LabelId::class;
    }
}
