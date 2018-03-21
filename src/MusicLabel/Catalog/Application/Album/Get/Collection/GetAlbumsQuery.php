<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Application\Album\Get\Collection;

use Masfernandez\Shared\Domain\Bus\Query\SyncQueryInterface;

final class GetAlbumsQuery implements SyncQueryInterface
{
    public function __construct(private int $page, private int $size, private array $fields, private array $filters, private array $sort)
    {
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
