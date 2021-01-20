<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\Token;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Stringable;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class TokenExpirationDate extends ValueObjectBase implements Stringable
{
    public const FORMAT = 'Y-m-d H:i:s';
    public const VALIDITY_PERIOD = '+5 days';

    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\DateTime()
        ];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}