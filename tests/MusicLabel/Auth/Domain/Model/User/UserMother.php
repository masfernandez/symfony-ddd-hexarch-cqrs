<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Domain\User\UserId;

class UserMother
{
    public static function create(
        ?UserId $id = null,
        ?\Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail $email = null,
        ?UserPassword $password = null,
    ): User {
        return User::create(
            id:       $id ?? UserIdMother::create(),
            email:    $email ?? UserEmailMother::create(),
            password: $password ?? UserPasswordMother::create(),
        );
    }
}
