<?php

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

class TokenResponse
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}