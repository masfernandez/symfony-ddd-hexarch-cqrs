<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Create;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\UserNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\WrongPassword;
use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebTokenGenerator;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;

final class JsonWebTokenCreator implements ApplicationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly JsonWebTokenGenerator $tokenGenerator,
    ) {
    }

    /**
     * @throws UserNotFound
     * @throws WrongPassword
     */
    public function execute(CreateJsonWebTokenCommand|Request $request): JsonWebTokenResponse
    {
        $user = $this->userRepository->getByEmail($request->getEmail())
            ?? throw new UserNotFound();

        $user->comparePassword($request->getPassword());

        $token = $this->tokenGenerator->create($user);

        return new JsonWebTokenResponse(
            signature:        $token->getSignature(),
            headerAndPayload: $token->getHeaderAndPayload(),
        );
    }
}
