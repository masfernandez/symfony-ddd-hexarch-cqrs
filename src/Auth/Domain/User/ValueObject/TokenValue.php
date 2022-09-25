<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\ValueObject\StringValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class TokenValue extends StringValueObject
{
    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return array_merge(
            parent::setConstraints(),
            [
                new Constraints\Length(['min' => Token::HEX_LENGTH, 'max' => Token::HEX_LENGTH]),
            ]
        );
    }
}
