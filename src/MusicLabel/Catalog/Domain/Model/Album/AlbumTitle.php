<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class AlbumTitle extends ValueObjectBase
{
    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Length(['min' => 1, 'max' => 255])
        ];
    }
}
