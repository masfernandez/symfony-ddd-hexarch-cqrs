<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\JsonWebToken;

use DateTimeImmutable;
use Lcobucci\JWT\Configuration as LcobucciConfiguration;
use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebToken;
use Masfernandez\MusicLabel\Auth\Domain\User\JsonWebTokenGenerator;
use Masfernandez\MusicLabel\Auth\Domain\User\User;
use Masfernandez\MusicLabel\Auth\Domain\User\ValueObject\JsonWebTokenValue;
use Masfernandez\ValueObject\ValueObjectException;

class Generator implements JsonWebTokenGenerator
{
    public function __construct(
        private readonly LcobucciConfiguration $lcobucciConfiguration,
        private readonly Configuration $configuration,
    ) {
    }

    /**
     * @throws ValueObjectException
     */
    public function create(User $user): JsonWebToken
    {
        $configuration = $this->lcobucciConfiguration;
        $now           = new DateTimeImmutable();

        $token = $configuration->builder()
            ->issuedBy($this->configuration->issuedBy())
            ->permittedFor($this->configuration->permittedFor())
            ->identifiedBy($this->configuration->identifiedBy())
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now->modify($this->configuration->beUsedAfter()))
            ->expiresAt($now->modify($this->configuration->expiresAt()))
            ->withClaim('uid', $user->getId()->value())
            //@todo roles...

            ->getToken(
                $configuration->signer(),
                $configuration->signingKey()
            );

        return JsonWebToken::create(
            value: new JsonWebTokenValue($token->toString()),
        );
    }
}
