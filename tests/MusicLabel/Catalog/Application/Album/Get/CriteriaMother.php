<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Criteria;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class CriteriaMother
{
    public static function create(
        ?array $exp = null,
        ?array $sort = null,
        ?int $page = null,
        ?int $size = null,
        ?array $fields = null,
    ): Criteria {
        return new Criteria(
            $exp ?? [], //@todo filters
            $sort ?? [],
            $page ?? FakerMother::random()->numberBetween(1, 10),
            $size ?? FakerMother::random()->numberBetween(1, 10),
            $fields ?? [],
        );
    }
}
