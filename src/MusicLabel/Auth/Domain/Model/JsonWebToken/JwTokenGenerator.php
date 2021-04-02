<?php

namespace Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken;

use Masfernandez\MusicLabel\Auth\Domain\Model\User\User;

interface JwTokenGenerator
{
    public function create(User $user): string;
}
