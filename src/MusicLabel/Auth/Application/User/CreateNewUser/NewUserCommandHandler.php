<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser;

use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Command\CommandHandler;

final class NewUserCommandHandler implements CommandHandler
{
    public function __construct(private ApplicationServiceInterface $userCreator)
    {
    }

    public function __invoke(NewUserCommand $command): void
    {
        $this->userCreator->execute($command);
    }
}
