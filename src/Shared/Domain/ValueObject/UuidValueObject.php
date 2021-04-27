<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Domain\ValueObject;

use Stringable;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

abstract class UuidValueObject extends Uuid implements Stringable
{
    private static array $constrains;

    /**
     * @return mixed[]
     */
    public static function getConstraints(): array
    {
        if (!isset(self::$constrains)) {
            self::$constrains = [new Assert\NotBlank(), new Assert\Uuid()];
        }
        return self::$constrains;
    }

    protected static function random(): self
    {
        return new static(Uuid::v4()->toRfc4122());
    }

    public function value(): string
    {
        return $this->uid;
    }

    public function __toString(): string
    {
        return $this->uid;
    }
}
