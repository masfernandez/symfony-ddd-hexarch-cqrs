<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Type\Auth;

use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;
use Masfernandez\MusicLabel\Infrastructure\Api\Type\Shared\DoctrineUuidType;

final class DoctrineUserId extends DoctrineUuidType
{
    protected function getFQCN(): string
    {
        return UserId::class;
    }
}
