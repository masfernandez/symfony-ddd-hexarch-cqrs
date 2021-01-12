<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\Token;

interface TokenRepository
{
    public function save(Token $token);

    public function getByValue(TokenValue $getToken): ?Token;
}