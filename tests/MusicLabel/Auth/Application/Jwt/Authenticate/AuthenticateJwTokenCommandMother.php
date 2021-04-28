<?php

namespace Masfernandez\Tests\MusicLabel\Auth\Application\Jwt\Authenticate;

use Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate\AuthenticateJwTokenCommand;
use Masfernandez\Tests\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenValueMother;

class AuthenticateJwTokenCommandMother
{
    public static function create(?string $token = null): AuthenticateJwTokenCommand
    {
        return new AuthenticateJwTokenCommand(
            $token ?? JwTokenValueMother::create()->value()
        );
    }
}
