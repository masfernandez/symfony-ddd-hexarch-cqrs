<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\Jwt\Authenticate;

use Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenValidator;
use Masfernandez\Shared\Application\Service\ApplicationServiceInterface;
use Masfernandez\Shared\Domain\Bus\Request\Request;

class JwTokenAuthenticator implements ApplicationServiceInterface
{
    public function __construct(private JwTokenValidator $tokenValidator)
    {
    }

    public function execute(AuthenticateJwTokenCommand|Request $request)
    {
        $this->tokenValidator->validate($request->getToken()->value());
    }
}
