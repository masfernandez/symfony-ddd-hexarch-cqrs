<?php

namespace Masfernandez\MusicLabel\Auth\Application\Token\Authenticate;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

class AuthenticateTokenHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $tokenAuthenticator)
    {
    }

    public function __invoke(AuthenticateTokenCommand $command)
    {
        $this->tokenAuthenticator->execute($command);
    }
}
