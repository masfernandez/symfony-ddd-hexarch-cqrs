<?php

declare(strict_types=1);

namespace Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection;

use Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection\SearchAlbumsQuery;
use Masfernandez\Tests\MusicLabel\Backoffice\Catalog\Domain\Album\AlbumFieldsMother;
use Masfernandez\Tests\MusicLabel\Shared\Infrastructure\PhpUnit\FakerMother;

class GetAlbumsQueryMother
{
    public static function create(
        ?int $page = null,
        ?int $size = null,
        ?array $fields = null,
        ?array $filters = null,
        ?array $sort = null
    ): SearchAlbumsQuery {
        return new SearchAlbumsQuery(
            page:    $page ?? FakerMother::random()->numberBetween(1, 10),
            size:    $size ?? FakerMother::random()->numberBetween(1, 10),
            fields:  $fields ?? AlbumFieldsMother::create(),
            filters: $filters ?? [],
            sort:    $sort ?? array_map(static function ($field): string {
                return FakerMother::random()->randomElement(['', '-']) . $field;
            }, AlbumFieldsMother::create()),
        );
    }
}
