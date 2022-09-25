<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineStringType;

final class DoctrineUserPassword extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return UserPassword::class;
    }
}
