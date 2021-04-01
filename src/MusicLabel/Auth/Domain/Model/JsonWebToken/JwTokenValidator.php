<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\Model\JsonWebToken;

interface JwTokenValidator
{
    public function validate($value);
}