<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class UserEmailMother
{
    public static function create(
        ?string $email = null,
    ): UserEmail {
        return new UserEmail(
            value: $email ?? FakerMother::random()->email(),
        );
    }
}
