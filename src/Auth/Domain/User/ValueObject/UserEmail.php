<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\MusicLabel\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class UserEmail extends ValueObjectBase
{
    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Email()
        ];
    }
}
