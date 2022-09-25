<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class UserCreator implements ApplicationService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * @throws UserAlreadyExists
     */
    public function execute(CreateUserCommand|Request $request): ?Response
    {
        $this->userRepository->add(
            User::create(
                id:       $request->getId(),
                email:    $request->getEmail(),
                password: $request->getPassword(),
            )
        );

        return null;
    }
}
