<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User;

use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

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
