<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenValue;
use Masfernandez\Shared\Domain\Bus\Command\Command;

class AuthenticateJwTokenCommand implements Command
{
    private JwTokenValue $token;

    public function __construct(?string $token)
    {
        $this->token = new JwTokenValue($token);
    }

    public function getToken(): JwTokenValue
    {
        return $this->token;
    }
}
