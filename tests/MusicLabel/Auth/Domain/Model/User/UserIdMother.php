<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\MusicLabel\Shared\Domain\User\UserId;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class UserIdMother
{
    public static function create(
        ?string $id = null,
    ): UserId {
        return new UserId(
            uuid: $id ?? FakerMother::random()->uuid(),
        );
    }
}
