<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

interface JsonWebTokenGenerator
{
    public function create(User $user): JsonWebToken;
}
