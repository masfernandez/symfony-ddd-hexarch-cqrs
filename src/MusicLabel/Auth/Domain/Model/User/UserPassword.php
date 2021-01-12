<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

class UserPassword extends ValueObjectBase
{
    //@todo Salted password (argon)

    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Length(['min' => 10, 'max' => 255])
        ];
    }
}