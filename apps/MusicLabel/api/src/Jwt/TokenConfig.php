<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Infrastructure\Api\Jwt;

class TokenConfig
{
    public function __construct(
        private readonly string $issued_by,
        private readonly string $identified_by,
        private readonly string $permitted_for,
        private readonly string $be_used_after,
        private readonly string $expires_at
    ) {
    }

    public function issuedBy(): string
    {
        return $this->issued_by;
    }

    public function identifiedBy(): string
    {
        return $this->identified_by;
    }

    public function permittedFor(): string
    {
        return $this->permitted_for;
    }

    public function beUsedAfter(): string
    {
        return $this->be_used_after;
    }

    public function expiresAt(): string
    {
        return $this->expires_at;
    }
}
