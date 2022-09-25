<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\User;

use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\UserMother;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\TokenValueMother;

class TokenMother
{
    public static function create(
        ?User $user = null,
        ?string $value = null,
    ): Token {
        return Token::create(
            user:  $user ?? UserMother::create(),
            value: $value ?? TokenValueMother::create(),
        );
    }
}
