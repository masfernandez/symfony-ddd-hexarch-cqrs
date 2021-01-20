<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Album;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints;

final class AlbumPublishingDate extends ValueObjectBase implements \Stringable
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
