<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Album\ValueObject;

use Masfernandez\MusicLabel\Shared\Domain\ValueObject\ValueObjectBase;
use Stringable;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class AlbumReleaseDate extends ValueObjectBase implements Stringable
{
    public const FORMAT = 'Y-m-d H:i:s';

    /**
     * @return Constraint[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\DateTime()
        ];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
