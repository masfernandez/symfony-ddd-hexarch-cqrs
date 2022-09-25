<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\JsonWebTokenValue;
use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Command\Command;
use Masfernandez\ValueObject\ValueObjectException;

class AuthenticateJwTokenCommand implements Command
{
    private readonly JsonWebTokenValue $token;

    /**
     * @throws ValueObjectException
     */
    public function __construct(
        ?string $tokenValue,
    ) {
        $this->token = new JsonWebTokenValue($tokenValue);
    }

    public function getToken(): JsonWebTokenValue
    {
        return $this->token;
    }
}
