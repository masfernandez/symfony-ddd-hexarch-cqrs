<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Artist;

use Masfernandez\MusicLabel\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class ArtistName extends ValueObjectBase
{
    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Length(['min' => 1, 'max' => 255])
        ];
    }
}
