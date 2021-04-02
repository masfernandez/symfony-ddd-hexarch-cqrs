<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Token\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\Model\Token\InvalidCredentials;
use Masfernandez\MusicLabel\Auth\Domain\Model\Token\TokenRepository;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

class TokenAuthenticator implements ApplicationServiceInterface
{
    public function __construct(private TokenRepository $tokenRepository)
    {
    }

    /**
     * @throws InvalidCredentials
     */
    public function execute(AuthenticateTokenCommand | Request $request)
    {
        $this->tokenRepository->getByValue($request->getToken()) ??
        throw new InvalidCredentials();
    }
}
