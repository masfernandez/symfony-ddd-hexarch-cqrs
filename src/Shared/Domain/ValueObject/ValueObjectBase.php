<?php

declare(strict_types=1);

namespace Masfernandez\Shared\Domain\ValueObject;

use RuntimeException;
use Symfony\Component\Validator\Validation;

abstract class ValueObjectBase
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $this->validateInput($value);
    }

    protected function validateInput($value)
    {
        $violations = Validation::createValidator()->validate($value, self::getConstraints());
        if (count($violations) > 0) {
            $detail = $violations[0]->getMessage();
            throw new RuntimeException($detail . " Value: $value. Object: " . self::class);
        }

        return $value;
    }

    /**
     * @return mixed[]
     */
    public static function getConstraints(): array
    {
        return static::defineConstraints();
    }

    /**
     * @return mixed[]
     */
    abstract protected static function defineConstraints(): array;

    public function value()
    {
        return $this->value;
    }
}
