<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\ValueObject\StringValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class UserEmail extends StringValueObject
{
    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return array_merge(
            parent::setConstraints(),
            [
                new Constraints\Email(),
                new Constraints\Length(['max' => 255]),
            ]
        );
    }
}
