<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\Exception\TokenNotFound;
use Masfernandez\MusicLabel\Auth\Domain\User\TokenRepository;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class TokenAuthenticator implements ApplicationService
{
    public function __construct(private TokenRepository $tokenRepository)
    {
    }

    /**
     * @throws TokenNotFound
     */
    public function execute(AuthenticateTokenCommand|Request $request): ?Response
    {
        $this->tokenRepository->getByValue($request->getToken()) ?? throw new TokenNotFound();
        return null;
    }
}
