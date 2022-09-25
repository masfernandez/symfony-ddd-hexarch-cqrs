<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Catalog;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\ValueObject\LabelName;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineStringType;

final class DoctrineLabelName extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return LabelName::class;
    }
}
