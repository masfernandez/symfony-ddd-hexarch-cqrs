<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\TokenValue;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;
use Masfernandez\ValueObject\Exception\ValueObjectException;

class AuthenticateTokenCommand implements Command
{
    private readonly TokenValue $token;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        string $token,
    ) {
        $this->token = new TokenValue($token);
    }

    public function getToken(): TokenValue
    {
        return $this->token;
    }
}
