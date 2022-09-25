<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Shared\Domain\Id;

use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class UserIdMother
{
    public static function create(
        ?string $id = null,
    ): UserId {
        return new UserId(
            value: $id ?? FakerMother::random()->uuid(),
        );
    }
}
