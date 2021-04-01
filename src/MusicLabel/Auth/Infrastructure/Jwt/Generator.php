<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Infrastructure\Jwt;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration;
use Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken\JwTokenGenerator;
use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;

class Generator implements JwTokenGenerator
{
    public function __construct(private Configuration $configuration, private TokenConfig $tokenConfig)
    {
    }

    public function create(User $user): string
    {
        $configuration = $this->configuration;
        $now = new DateTimeImmutable();
        $token = $configuration->builder()
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
