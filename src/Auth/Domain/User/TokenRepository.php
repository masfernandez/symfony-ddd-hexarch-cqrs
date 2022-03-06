<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;

interface TokenRepository
{
    public function save(Token $token);

    public function getByValue(TokenValue $token): ?Token;
}
