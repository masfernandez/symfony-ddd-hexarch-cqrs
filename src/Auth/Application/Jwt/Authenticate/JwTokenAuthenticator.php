<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\User\JwTokenValidator;
use Masfernandez\MusicLabel\Shared\Application\Service\ApplicationService;
use Masfernandez\MusicLabel\Shared\Application\Service\Request;
use Masfernandez\MusicLabel\Shared\Application\Service\Response;

class JwTokenAuthenticator implements ApplicationService
{
    public function __construct(private readonly JwTokenValidator $tokenValidator)
    {
    }

    public function execute(AuthenticateJwTokenCommand|Request $request): ?Response
    {
        $this->tokenValidator->validate($request->getToken()->value());
        return null;
    }
}
