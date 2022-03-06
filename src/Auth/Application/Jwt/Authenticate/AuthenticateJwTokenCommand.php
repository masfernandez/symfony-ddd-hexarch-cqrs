<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\JwTokenValue;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;

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
