<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenExpirationDate;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineDateTimeType;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\ValueObjectType;

final class DoctrineTokenExpirationDate extends DoctrineDateTimeType implements ValueObjectType
{
    protected function getFQCN(): string
    {
        return TokenExpirationDate::class;
    }
}
