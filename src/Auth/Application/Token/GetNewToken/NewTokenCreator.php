<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword;
use Masfernandez\MusicLabel\Auth\Domain\User\Token;
use Masfernandez\MusicLabel\Auth\Domain\User\TokenRepository;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class NewTokenCreator implements ApplicationService
{
    public function __construct(private UserRepository $userRepository, private TokenRepository $tokenRepository)
    {
    }

    /** @throws UserNotFound
     * @throws \Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword
     */
    public function execute(GetTokenQuery|Request $request): TokenResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail())
            ?? throw new UserNotFound();

        if (!$user->comparePassword($request->getPassword())) {
            throw new WrongPassword();
        }

        $token = Token::create($user);
        $this->tokenRepository->save($token);
        return new TokenResponse($token->value());
    }
}
