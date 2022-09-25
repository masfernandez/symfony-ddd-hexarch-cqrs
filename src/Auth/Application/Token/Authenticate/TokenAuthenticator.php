<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\TokenExpired;
use Masfernandez\MusicLabel\Auth\Domain\User\Exception\TokenNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\UserRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class TokenAuthenticator implements ApplicationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    /**
     * @throws TokenNotFound
     * @throws TokenExpired
     */
    public function execute(Request|AuthenticateTokenCommand $request): ?Response
    {
        $user = $this->userRepository->searchByToken($request->getToken()) ??
            throw new TokenNotFound();

        $user->authenticate();

        return null;
    }
}
