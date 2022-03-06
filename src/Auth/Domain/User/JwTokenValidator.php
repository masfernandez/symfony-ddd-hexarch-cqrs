<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User;

interface JwTokenValidator
{
    public function validate($value);
}
