<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

interface JwTokenGenerator
{
    public function create(User $user): string;
}
