<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\User\CreateNewUser;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserAlreadyExists;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserEmail;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserPassword;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Domain\Model\User\UserId;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class UserCreator implements ApplicationServiceInterface
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    /** @throws UserAlreadyExists */
    public function execute(NewUserCommand | Request $request): void
    {
        $this->userRepository->post(
            new User(
                new UserId(UserId::v4()->toRfc4122()),
                new UserEmail($request->getEmail()),
                //@todo salt password here...
                new UserPassword($request->getPassword())
            )
        );
    }
}
