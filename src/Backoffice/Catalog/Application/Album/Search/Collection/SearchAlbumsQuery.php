<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Backoffice\Catalog\Application\Album\Search\Collection;

use Masfernandez\MusicLabel\Infrastructure\Api\Bus\Query\SyncQuery;

final class SearchAlbumsQuery implements SyncQuery
{
    public function __construct(
        private readonly int $page,
        private readonly int $size,
        private readonly array $fields,
        private readonly array $filters,
        private readonly array $sort,
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return string[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return string[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return string[]
     */
    public function getSort(): array
    {
        return $this->sort;
    }
}
