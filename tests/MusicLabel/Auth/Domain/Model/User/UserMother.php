<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserPassword;
use Masfernandez\MusicLabel\Shared\Domain\Model\User\UserId;

class UserMother
{
    public static function create(
        ?UserId $id = null,
        ?UserEmail $email = null,
        ?UserPassword $password = null
    ): User
    {
        return new User(
            $id ?? UserIdMother::create(),
            $email ?? UserEmailMother::create(),
            $password ?? UserPasswordMother::create(),
        );
    }
}