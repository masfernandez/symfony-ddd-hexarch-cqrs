<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken;

final class JwtResponse
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getHeaderAndPayload(): string
    {
        $tokenParts = explode('.', $this->token);
        return $tokenParts[0] . '.' . $tokenParts[1];
    }

    public function getSignature(): string
    {
        $tokenParts = explode('.', $this->token);
        return $tokenParts[2];
    }
}
