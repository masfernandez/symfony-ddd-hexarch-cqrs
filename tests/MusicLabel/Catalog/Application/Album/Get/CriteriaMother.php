<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get;

use Masfernandez\MusicLabel\Catalog\Application\Album\Criteria;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class CriteriaMother
{
    public static function create(
        ?array $exp = null,
        ?array $sort = null,
        ?int $page = null,
        ?int $size = null,
    ): Criteria {
        return new Criteria(
            exp:  $exp ?? [], //@todo filters
            sort: $sort ?? [],
            page: $page ?? FakerMother::random()->numberBetween(1, 10),
            size: $size ?? FakerMother::random()->numberBetween(1, 10),
        );
    }
}
