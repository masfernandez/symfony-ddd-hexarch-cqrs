<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Label\ValueObject;

use Masfernandez\ValueObject\StringValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class LabelName extends StringValueObject
{
    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Length(['max' => 255])
        ];
    }
}
