<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\UserPassword;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;
use Masfernandez\MusicLabel\Shared\Domain\User\UserId;

final class UserCreator implements ApplicationService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /** @throws UserAlreadyExists */
    public function execute(NewUserCommand|Request $request): ?Response
    {
        $this->userRepository->post(
            User::create(
                new UserId(UserId::v4()->toRfc4122()),
                new UserEmail($request->getEmail()),
                new UserPassword(password_hash($request->getPassword(), PASSWORD_ARGON2ID))
            )
        );

        return null;
    }
}
