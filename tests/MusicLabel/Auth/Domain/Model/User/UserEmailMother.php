<?php

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserEmail;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class UserEmailMother
{
    public static function create(?string $email = null): UserEmail
    {
        return new UserEmail(
            $email ?? FakerMother::random()->email
        );
    }
}