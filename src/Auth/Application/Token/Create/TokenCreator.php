<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class TokenCreator implements ApplicationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws UserNotFound
     * @throws WrongPassword
     */
    public function execute(CreateTokenCommand|Request $request): TokenResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail())
            ?? throw new UserNotFound();

        $token = $user->createNewToken($request->getPassword());

        return new TokenResponse($token->value());
    }
}
