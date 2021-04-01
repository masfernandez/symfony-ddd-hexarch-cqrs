<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\Token;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class TokenValue extends ValueObjectBase
{
    public const BYTES_LENGTH = 32;
    public const HEX_LENGTH = 64;

    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Length(['min' => self::HEX_LENGTH, 'max' => self::HEX_LENGTH]),
        ];
    }
}
