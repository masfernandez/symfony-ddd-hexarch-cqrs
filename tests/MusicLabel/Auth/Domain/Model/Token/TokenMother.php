<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token;

use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenExpirationDate;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Shared\Domain\User\TokenId;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserMother;

class TokenMother
{
    public static function create(
        ?User $user = null,
        ?TokenValue $tokenValue = null,
        ?TokenExpirationDate $tokenExpirationDate = null,
        ?TokenId $tokenId = null,
    ): Token {
        return new Token(
            user:            $user ?? UserMother::create(),
            value:           $tokenValue ?? TokenValueMother::create(),
            expiration_date: $tokenExpirationDate ?? TokenExpirationDateMother::create(),
            id:              $tokenId ?? TokenIdMother::create(),
        );
    }
}
