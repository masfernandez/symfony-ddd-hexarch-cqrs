<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Auth\Application\JsonWebToken\Authenticate;

use Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Authenticate\AuthenticateJwTokenCommand;
use Masfernandez\Tests\MusicLabel\Auth\Domain\User\ValueObject\JwTokenValueMother;

class AuthenticateJwTokenCommandMother
{
    public static function create(?string $token = null): AuthenticateJwTokenCommand
    {
        return new AuthenticateJwTokenCommand(
            tokenValue: $token ?? JwTokenValueMother::create()->value(),
        );
    }
}
