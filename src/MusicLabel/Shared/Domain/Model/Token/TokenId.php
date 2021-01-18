<?php

namespace Masfernandez\MusicLabel\Shared\Domain\Model\Token;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Stringable;
use Symfony\Component\Validator\Constraint;

class TokenId extends ValueObjectBase implements Stringable
{
    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [];
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function value(): int
    {
        return (int)$this->value;
    }
}