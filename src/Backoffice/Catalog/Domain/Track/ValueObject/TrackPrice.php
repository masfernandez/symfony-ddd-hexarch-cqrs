<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Track\ValueObject;

use Masfernandez\ValueObject\FloatValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class TrackPrice extends FloatValueObject
{
    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\NotNull(),
            new Constraints\Positive(),
        ];
    }
}
