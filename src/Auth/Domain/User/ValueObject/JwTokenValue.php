<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Auth\Domain\User\ValueObject;

use Masfernandez\MusicLabel\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints as Assert;

class JwTokenValue extends ValueObjectBase
{
    public final const JWT_PATTERN = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_\-\+\/=]*)/';
    public final const JWT_HEAD_AND_PAY_PATTERN = '/^([a-zA-Z0-9_=]+)\.([a-zA-Z0-9_=]+)/';

    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\Regex(['pattern' => self::JWT_PATTERN,])
        ];
    }
}
