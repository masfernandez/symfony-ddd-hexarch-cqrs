<?php

namespace Masfernandez\Tests\MusicLabel\Auth\Domain\Model\Token;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\Token;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenExpirationDate;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenValue;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;
use Masfernandez\MusicLabel\Shared\Domain\Model\Token\TokenId;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\User\UserMother;

class TokenMother
{
    public static function create(
        ?User $user = null,
        ?TokenValue $tokenValue = null,
        ?TokenExpirationDate $tokenExpirationDate = null,
        ?TokenId $tokenId = null
    ): Token
    {
        return new Token(
            $user ?? UserMother::create(),
            $tokenValue ?? TokenValueMother::create(),
            $tokenExpirationDate ?? TokenExpirationDateMother::create(),
            $tokenId ?? TokenIdMother::create()
        );
    }
}