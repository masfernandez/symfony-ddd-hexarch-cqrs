<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenValue;
use Masfernandez\Shared\Domain\Bus\Command\Command;

class AuthenticateTokenCommand implements Command
{
    private TokenValue $token;

    public function __construct(string $token)
    {
        $this->token = new TokenValue($token);
    }

    public function getToken(): TokenValue
    {
        return $this->token;
    }
}
