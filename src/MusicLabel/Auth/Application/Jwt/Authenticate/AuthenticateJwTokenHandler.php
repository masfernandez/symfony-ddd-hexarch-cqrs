<?php

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

class AuthenticateJwTokenHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $jwTokenAuthenticator)
    {
    }

    public function __invoke(AuthenticateJwTokenCommand $command)
    {
        $this->jwTokenAuthenticator->execute($command);
    }
}
