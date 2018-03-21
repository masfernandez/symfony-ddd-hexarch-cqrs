<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Artist;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraints;

final class ArtistSpecialisation extends ValueObjectBase
{
    /**
     * @return \Symfony\Component\Validator\Constraints\Length[]|\Symfony\Component\Validator\Constraints\NotBlank[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\Length(['min' => 1, 'max' => 255])
        ];
    }
}
