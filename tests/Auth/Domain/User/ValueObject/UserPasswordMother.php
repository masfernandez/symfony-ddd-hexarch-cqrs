<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class UserPasswordMother
{
    public static function create(
        ?string $password = null,
    ): \Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword {
        $noSaltedPassword = $password ??
            FakerMother::random()->lexify(
                '??????????????????????????'
            );
        return new \Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword(
            value: password_hash($noSaltedPassword, PASSWORD_ARGON2ID)
        );
    }
}
