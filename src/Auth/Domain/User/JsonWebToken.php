<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\JsonWebTokenValue;
use ReflectionClass;
use Stringable;

class JsonWebToken implements Stringable
{
    public final const JWT_HEAD_AND_PAYLOAD_PATTERN = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)/';
    public final const JWT_PATTERN                  = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)/';

    private function __construct(
        private readonly JsonWebTokenValue $value,
    ) {
    }

    public static function create(
        JsonWebTokenValue $value,
    ): JsonWebToken {
        return new self(
            value: $value,
        );
    }

    public function getValue(): JsonWebTokenValue
    {
        return $this->value;
    }

    public function getSignature(): string
    {
        $tokenParts = explode('.', $this->value->value());
        return $tokenParts[2];
    }

    public function getHeaderAndPayload(): string
    {
        $tokenParts = explode('.', $this->value->value());
        return $tokenParts[0] . '.' . $tokenParts[1];
    }

    public function __toString(): string
    {
        return (new ReflectionClass($this))->getShortName() . ":{$this->value->value()}";
    }
}
