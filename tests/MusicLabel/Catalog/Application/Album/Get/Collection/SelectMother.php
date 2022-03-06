<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Catalog\Domain\Album\Select;

class SelectMother
{
    public static function create(
        ?array $fields = [],
        ?string $alias = 'a',
        ?bool $fetchArray = false,
    ): Select {
        return new Select(
            fields:     $fields ?? array_keys(AlbumAssembler::$jsonMappingToEntity),
            alias:      $alias,
            fetchArray: $fetchArray,
        );
    }
}
