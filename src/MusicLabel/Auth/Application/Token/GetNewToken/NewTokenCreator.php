<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\Token;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenRepository;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserRepository;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\WrongPassword;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class NewTokenCreator implements ApplicationServiceInterface
{
    public function __construct(private UserRepository $userRepository, private TokenRepository $tokenRepository)
    {
    }

    /** @throws UserNotFound
     * @throws WrongPassword
     */
    public function execute(GetTokenQuery | Request $request): TokenResponse
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
