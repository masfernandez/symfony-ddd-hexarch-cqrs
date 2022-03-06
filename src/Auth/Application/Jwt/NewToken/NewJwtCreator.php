<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword;
use Masfernandez\MusicLabel\Auth\Domain\User\JwTokenGenerator;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class NewJwtCreator implements ApplicationService
{
    public function __construct(
        private UserRepository $userRepository,
        private JwTokenGenerator $tokenGenerator
    ) {
    }

    /**
     * @throws \Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound
     * @throws \Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword
     */
    public function execute(GetJwtQuery|Request $request): JwtResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail())
            ?? throw new UserNotFound();

        if (!$user->comparePassword($request->getPassword())) {
            throw new WrongPassword();
        }

        $token = $this->tokenGenerator->create($user);
        return new JwtResponse($token);
    }
}
