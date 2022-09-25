<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\User;

use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Domain\Id\UserId;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\UserEmailMother;
use Masfernandez\Tests\MusicLabel\Shared\Domain\Id\UserIdMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\UserPasswordMother;

class UserMother
{
    public static function create(
        ?UserId $id = null,
        ?UserEmail $email = null,
        ?UserPassword $password = null,
    ): User {
        return User::create(
            id:       $id ?? UserIdMother::create(),
            email:    $email ?? UserEmailMother::create(),
            password: $password ?? UserPasswordMother::create(),
        );
    }
}
