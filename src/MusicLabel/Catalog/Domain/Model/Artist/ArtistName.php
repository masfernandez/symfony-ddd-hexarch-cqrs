<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Model\Artist;

use Masfernandez\Shared\Domain\ValueObject\ValueObjectBase;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ArtistName extends ValueObjectBase
{
    /**
     * @return Length[]|NotBlank[]
     */
    protected static function defineConstraints(): array
    {
        return [
            new NotBlank(),
            new Length(['min' => 1, 'max' => 255])];
    }
}
