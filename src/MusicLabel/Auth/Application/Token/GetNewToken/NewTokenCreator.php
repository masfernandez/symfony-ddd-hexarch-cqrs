<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\GetNewToken;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\InvalidCredentials;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\Token;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenRepository;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\RequestInterface;

class NewTokenCreator implements ApplicationServiceInterface
{
    public function __construct(private UserRepository $userRepository, private TokenRepository $tokenRepository)
    {
    }

    public function execute(GetTokenQuery|RequestInterface $request): TokenResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail())
            ?? throw new UserNotFound();

        if (!$user->comparePassword($request->getPassword())) {
            // @todo message here
            throw new InvalidCredentials('nooop');
        }

        $token = Token::create($user);
        $this->tokenRepository->save($token);
        return new TokenResponse($token->value());
    }
}
