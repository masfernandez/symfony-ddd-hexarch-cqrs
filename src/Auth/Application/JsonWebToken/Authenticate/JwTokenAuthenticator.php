<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebToken;
use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebTokenValidator;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class JwTokenAuthenticator implements ApplicationService
{
    public function __construct(
        private readonly JsonWebTokenValidator $tokenValidator,
    ) {
    }

    public function execute(AuthenticateJwTokenCommand|Request $request): ?Response
    {
        $this->tokenValidator->validate(
            JsonWebToken::create(
                value: $request->getToken(),
            )
        );
        return null;
    }
}
