<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection\GetAlbumsQuery;
use Masfernandez\Tests\MusicLabel\Catalog\Domain\Model\Album\AlbumFieldsMother;
use Masfernandez\Tests\Shared\Infrastructure\PhpUnit\FakerMother;

class GetAlbumsQueryMother
{
    public static function create(
        ?int $page = null,
        ?int $size = null,
        ?array $fields = null,
        ?array $filters = null,
        ?array $sort = null
    ): GetAlbumsQuery {
        return new GetAlbumsQuery(
            $page ?? FakerMother::random()->numberBetween(1, 10),
            $size ?? FakerMother::random()->numberBetween(1, 10),
            $fields ?? AlbumFieldsMother::create(),
            $filters ?? [],
            $sort ?? array_map(static function ($field): string {
                return FakerMother::random()->randomElement(['', '-']) . $field;
            }, AlbumFieldsMother::create()),
        );
    }
}
