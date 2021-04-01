<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

final class TokenResponse
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
