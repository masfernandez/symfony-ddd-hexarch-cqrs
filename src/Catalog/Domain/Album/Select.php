<?php

declare(strict_types=1);

namespace Masfernandez\MusicLabel\Catalog\Domain\Album;

class Select
{
    public function __construct(
        private array $fields,
        private ?string $alias = 'a',
        private ?bool $fetchArray = false,
    ) {
    }

    public function getFields(): ?string
    {
        $alias = $this->alias;

        if (!$this->fetchArray) {
            return $alias;
        }

        return implode(
            ',',
            array_map(static function ($field) use ($alias) {
                return "$alias.$field";
            }, $this->fields)
        );
    }

    public function getFetchArray(): ?bool
    {
        return $this->fetchArray;
    }
}
