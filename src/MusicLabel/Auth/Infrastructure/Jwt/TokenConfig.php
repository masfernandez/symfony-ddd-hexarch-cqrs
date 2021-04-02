<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Infrastructure\Jwt;

class TokenConfig
{
    // phpcs:disable
    public function __construct(
        private string $issued_by,
        private string $identified_by,
        private string $permitted_for,
        private string $be_used_after,
        private string $expires_at
    ) {
    }
    // phpcs:enable

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
