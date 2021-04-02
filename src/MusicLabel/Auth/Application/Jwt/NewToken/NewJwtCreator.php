<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\NewToken;

use Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenGenerator;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\InvalidCredentials;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\UserRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

final class NewJwtCreator implements ApplicationServiceInterface
{
    public function __construct(private UserRepository $userRepository, private JwTokenGenerator $tokenGenerator)
    {
    }

    /**
     * @throws InvalidCredentials
     * @throws UserNotFound
     */
    public function execute(GetJwtQuery | Request $request): JwtResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail())
            ?? throw new UserNotFound();

        if (!$user->comparePassword($request->getPassword())) {
            throw new InvalidCredentials();
        }

        $token = $this->tokenGenerator->create($user);
        return new JwtResponse($token);
    }
}
