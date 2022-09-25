<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

interface JsonWebTokenValidator
{
    public function validate(JsonWebToken $jwToken);
}
