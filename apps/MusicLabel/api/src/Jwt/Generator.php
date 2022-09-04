<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Jwt;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Masfernandez\MusicLabel\Auth\Domain\User\JwTokenGenerator;
use Masfernandez\MusicLabel\Auth\Domain\User\User;

class Generator implements JwTokenGenerator
{
    public function __construct(private readonly Configuration $configuration, private readonly TokenConfig $tokenConfig)
    {
    }

    public function create(User $user): string
    {
        $configuration = $this->configuration;
        $now           = new DateTimeImmutable();
        $token         = $configuration->builder()
            ->issuedBy($this->tokenConfig->issuedBy())
            ->permittedFor($this->tokenConfig->permittedFor())
            ->identifiedBy($this->tokenConfig->identifiedBy())
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify($this->tokenConfig->beUsedAfter()))
            ->expiresAt($now->modify($this->tokenConfig->expiresAt()))
            ->withClaim('uid', $user->getId()->value())
            //@todo roles...

            ->getToken(
                $configuration->signer(),
                $configuration->signingKey()
            );

        return $token->toString();
    }
}
