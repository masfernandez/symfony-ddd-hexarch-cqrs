<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebToken;
use Masfernandez\ValueObject\StringValueObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

class JsonWebTokenValue extends StringValueObject
{
    /**
     * @return Constraint[]
     */
    protected static function setConstraints(): array
    {
        return array_merge(
            parent::setConstraints(),
            [
                new Assert\Regex(['pattern' => JsonWebToken::JWT_PATTERN,])
            ]
        );
    }
}
