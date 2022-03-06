<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class TokenResponse implements Response
{
    public function __construct(private string $token)
    {
    }

    public function getToken(): string
    {
        return $this->token;
    }
}
