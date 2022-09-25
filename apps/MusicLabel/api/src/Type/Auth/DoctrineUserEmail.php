<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineStringType;

final class DoctrineUserEmail extends DoctrineStringType
{
    protected function getFQCN(): string
    {
        return UserEmail::class;
    }
}
