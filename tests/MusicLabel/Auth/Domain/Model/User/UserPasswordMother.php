<?php

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserPassword;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class UserPasswordMother
{
    public static function create(?string $password = null): UserPassword
    {
        return new UserPassword(
            $password ?? FakerMother::random()->lexify(
                '??????????????????????????'
            )
        );
    }
}