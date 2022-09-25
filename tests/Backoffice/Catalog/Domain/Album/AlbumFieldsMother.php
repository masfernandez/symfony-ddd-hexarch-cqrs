<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album;

use Masfernandez\MusicLabel\Backoffice\Catalog\Domain\Album\Album;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class AlbumFieldsMother
{
    public static function create(?array $fields = []): ?array
    {
        if (count($fields) !== 0) {
            return $fields;
        }

        $result      = [];
        $albumFields = Album::getFieldNames();
        $total       = FakerMother::random()->numberBetween(1, count($albumFields));

        for ($i = 0; $i < $total; $i++) {
            $field    = FakerMother::random()->numberBetween(0, count($albumFields) - 1);
            $result[] = $albumFields[$field];
            unset($albumFields[$field]);
            $albumFields = array_values($albumFields); // reindex
        }

        return $result;
    }
}
