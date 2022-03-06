<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

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
