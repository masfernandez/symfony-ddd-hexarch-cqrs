<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineStringType;

final class DoctrineTokenValue extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return TokenValue::class;
    }
}
