<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Application\JsonWebToken\Create;

use Masfernandez\MusicLabel\Shared\Application\Service\Response;

final class JsonWebTokenResponse implements Response
{
    public function __construct(
        private readonly string $signature,
        private readonly string $headerAndPayload,
    ) {
    }

    public function getHeaderAndPayload(): string
    {
        return $this->headerAndPayload;
    }

    public function getSignature(): string
    {
        return $this->signature;
    }
}
