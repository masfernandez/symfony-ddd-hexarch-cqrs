<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\AlbumAssembler;
use Masfernandez\MusicLabel\Shared\Application\Select;

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
